<?php

declare(strict_types=1);

namespace App\Modules\Support;

use App\Modules\Accounts\Models\JournalLine;
use App\Modules\Delivery\Models\SalesInvoice;
use App\Modules\Inventory\Models\StockLedger;
use App\Modules\Knitting\Models\Roll;
use App\Modules\Operations\Models\Issue;
use Illuminate\Support\Facades\Schema;

final class ReportBook
{
    /**
     * @return array{headers: list<string>, rows: list<list<mixed>>}
     */
    public function rows(string $report): array
    {
        return match ($report) {
            'yarn-stock' => $this->table(StockLedger::query()->where('stock_type', 'yarn')->limit(5000)->get(), ['stock_type', 'item_id', 'lot_id', 'qty_in', 'qty_out', 'balance_qty', 'rate']),
            'rolls' => $this->table(Schema::hasTable('rolls') ? Roll::query()->limit(5000)->get() : collect(), ['number', 'gsm', 'net_kg', 'stage', 'grade']),
            'invoices' => $this->table(SalesInvoice::query()->limit(5000)->get(), ['number', 'subtotal', 'vat', 'total', 'status']),
            'journals' => $this->table(JournalLine::query()->limit(5000)->get(), ['journal_id', 'account_id', 'debit', 'credit']),
            'issues' => $this->table(Issue::query()->limit(5000)->get(), ['rule_key', 'severity', 'title', 'status']),
            default => ['headers' => ['report'], 'rows' => [[$report]]],
        };
    }

    /** @return list<string> */
    public function names(): array
    {
        return ['yarn-stock', 'rolls', 'invoices', 'journals', 'issues', 'production', 'grey-stock', 'delivery', 'attendance', 'profitability'];
    }

    /**
     * @param  iterable<int, mixed>  $models
     * @param  list<string>  $headers
     * @return array{headers: list<string>, rows: list<list<mixed>>}
     */
    private function table(iterable $models, array $headers): array
    {
        $rows = [];
        foreach ($models as $model) {
            $rows[] = array_map(fn (string $header) => $model->{$header} ?? null, $headers);
        }

        return ['headers' => $headers, 'rows' => $rows];
    }
}
