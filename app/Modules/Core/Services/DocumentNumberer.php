<?php

declare(strict_types=1);

namespace App\Modules\Core\Services;

use App\Modules\Core\Models\DocumentSequence;
use Illuminate\Support\Facades\DB;

final class DocumentNumberer
{
    public function next(string $docType, string $prefix, int $companyId, ?int $unitId = null, ?string $unitCode = null, ?string $fyCode = null): string
    {
        $fy = $fyCode ?? $this->financialYearCode();

        $number = DB::transaction(function () use ($docType, $prefix, $companyId, $unitId, $fy): int {
            $sequence = DocumentSequence::query()
                ->where('company_id', $companyId)
                ->where('doc_type', $docType)
                ->where('fy_code', $fy)
                ->when($unitId, fn ($query) => $query->where('unit_id', $unitId), fn ($query) => $query->whereNull('unit_id'))
                ->lockForUpdate()
                ->first();

            if (! $sequence instanceof DocumentSequence) {
                $sequence = new DocumentSequence([
                    'company_id' => $companyId,
                    'unit_id' => $unitId,
                    'doc_type' => $docType,
                    'prefix' => $prefix,
                    'fy_code' => $fy,
                    'last_number' => 0,
                ]);
                $sequence->save();
            }

            $next = ((int) $sequence->last_number) + 1;
            $sequence->last_number = $next;
            $sequence->prefix = $prefix;
            $sequence->save();

            return $next;
        });

        $unit = $unitCode !== null && $unitCode !== '' ? $unitCode : '00';

        return sprintf('%s/%s/%s/%05d', $prefix, $fy, $unit, $number);
    }

    public function financialYearCode(?\DateTimeInterface $date = null): string
    {
        $date ??= now();
        $year = (int) $date->format('Y');
        $month = (int) $date->format('n');
        $start = $month >= 7 ? $year : $year - 1;

        return substr((string) $start, 2).substr((string) ($start + 1), 2);
    }
}
