<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Services;

use App\Modules\Accounts\Models\Account;
use App\Modules\Accounts\Models\Journal;
use App\Modules\Accounts\Models\JournalLine;
use App\Modules\Core\Services\DocumentNumberer;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class LedgerPoster
{
    public function __construct(private readonly DocumentNumberer $numbers) {}

    /**
     * @param  list<array{account: string, debit?: float, credit?: float, party_id?: int|null}>  $lines
     */
    public function post(int $companyId, ?int $unitId, string $narration, array $lines, ?string $sourceType = null, ?int $sourceId = null, ?string $date = null): Journal
    {
        $debits = round(array_sum(array_map(fn (array $line): float => (float) ($line['debit'] ?? 0), $lines)), 2);
        $credits = round(array_sum(array_map(fn (array $line): float => (float) ($line['credit'] ?? 0), $lines)), 2);
        if (abs($debits - $credits) > 0.009 || $debits <= 0) {
            throw new RuntimeException('A journal must balance and carry a value.');
        }

        return DB::transaction(function () use ($companyId, $unitId, $narration, $lines, $sourceType, $sourceId, $date, $debits): Journal {
            $journal = Journal::query()->create([
                'company_id' => $companyId,
                'unit_id' => $unitId,
                'number' => $this->numbers->next('JV', 'JV', $companyId, $unitId, '00'),
                'journal_date' => $date ?? now()->toDateString(),
                'source_type' => $sourceType,
                'source_id' => $sourceId,
                'narration' => $narration,
                'status' => 'draft',
            ]);

            foreach ($lines as $line) {
                $account = Account::query()->where('company_id', $companyId)->where('code', $line['account'])->first();
                if (! $account instanceof Account) {
                    throw new RuntimeException('Missing ledger account '.$line['account']);
                }

                JournalLine::query()->create([
                    'company_id' => $companyId,
                    'journal_id' => $journal->id,
                    'account_id' => $account->id,
                    'party_id' => $line['party_id'] ?? null,
                    'debit' => round((float) ($line['debit'] ?? 0), 2),
                    'credit' => round((float) ($line['credit'] ?? 0), 2),
                    'currency_code' => 'BDT',
                ]);
            }

            $journal->markStatus('posted');

            $posted = round((float) $journal->lines()->sum('debit'), 2);
            if (abs($posted - $debits) > 0.01) {
                throw new RuntimeException('Posted journal lines do not match the voucher total.');
            }

            return $journal;
        });
    }

    public function balance(int $companyId, string $accountCode): float
    {
        $account = Account::query()->where('company_id', $companyId)->where('code', $accountCode)->first();
        if (! $account instanceof Account) {
            return 0.0;
        }

        $debit = (float) JournalLine::query()->where('account_id', $account->id)->sum('debit');
        $credit = (float) JournalLine::query()->where('account_id', $account->id)->sum('credit');

        return round($debit - $credit, 2);
    }
}
