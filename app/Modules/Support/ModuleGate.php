<?php

declare(strict_types=1);

namespace App\Modules\Support;

use App\Modules\Core\Models\CompanyModule;

final class ModuleGate
{
    public static function allows(string $moduleKey): bool
    {
        $companyId = CompanyContext::id();
        if ($companyId === null) {
            return true;
        }

        $row = CompanyModule::query()
            ->where('company_id', $companyId)
            ->where('module_key', $moduleKey)
            ->first();

        return $row === null || (bool) $row->enabled;
    }
}
