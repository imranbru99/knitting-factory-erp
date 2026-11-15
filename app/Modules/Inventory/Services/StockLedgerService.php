<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Services;

use App\Modules\Inventory\Models\StockLedger;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class StockLedgerService
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function move(array $attributes): StockLedger
    {
        return DB::transaction(function () use ($attributes): StockLedger {
            $qtyIn = round((float) ($attributes['qty_in'] ?? 0), 4);
            $qtyOut = round((float) ($attributes['qty_out'] ?? 0), 4);
            if ($qtyIn < 0 || $qtyOut < 0 || ($qtyIn > 0 && $qtyOut > 0) || ($qtyIn == 0.0 && $qtyOut == 0.0)) {
                throw new RuntimeException('A stock movement needs a positive quantity in one direction.');
            }

            $key = (string) ($attributes['movement_key'] ?? '');
            if ($key !== '') {
                $existing = StockLedger::query()->where('movement_key', $key)->first();
                if ($existing instanceof StockLedger) {
                    return $existing;
                }
            }

            $query = StockLedger::query()
                ->where('company_id', $attributes['company_id'])
                ->where('warehouse_id', $attributes['warehouse_id'])
                ->where('stock_type', $attributes['stock_type'])
                ->where('item_id', $attributes['item_id']);

            if (! empty($attributes['lot_id'])) {
                $query->where('lot_id', $attributes['lot_id']);
            } else {
                $query->whereNull('lot_id');
            }

            (clone $query)->orderBy('id')->lockForUpdate()->get();
            $balance = round((float) (clone $query)->sum(DB::raw('qty_in - qty_out')), 4);
            $rate = round((float) ($attributes['rate'] ?? 0), 4);

            if ($qtyOut > 0) {
                if ($balance + 0.0001 < $qtyOut) {
                    throw new RuntimeException('Insufficient stock for this lot and warehouse.');
                }
                $rate = $this->fifoRate($attributes, $qtyOut);
            }

            $next = round($balance + $qtyIn - $qtyOut, 4);

            return StockLedger::query()->create([
                'company_id' => $attributes['company_id'],
                'unit_id' => $attributes['unit_id'] ?? null,
                'warehouse_id' => $attributes['warehouse_id'],
                'stock_type' => $attributes['stock_type'],
                'item_id' => $attributes['item_id'],
                'lot_id' => $attributes['lot_id'] ?? null,
                'qty_in' => $qtyIn,
                'qty_out' => $qtyOut,
                'balance_qty' => $next,
                'rate' => $rate,
                'amount' => round(($qtyIn > 0 ? $qtyIn : $qtyOut) * $rate, 2),
                'ref_type' => $attributes['ref_type'] ?? null,
                'ref_id' => $attributes['ref_id'] ?? null,
                'movement_key' => $key !== '' ? $key : null,
                'moved_at' => $attributes['moved_at'] ?? now(),
                'created_by' => $attributes['created_by'] ?? auth()->id(),
            ]);
        });
    }

    public function onHand(int $companyId, int $warehouseId, string $stockType, int $itemId, ?int $lotId = null): float
    {
        $query = StockLedger::query()
            ->where('company_id', $companyId)
            ->where('warehouse_id', $warehouseId)
            ->where('stock_type', $stockType)
            ->where('item_id', $itemId);

        if ($lotId) {
            $query->where('lot_id', $lotId);
        }

        return round((float) $query->sum(DB::raw('qty_in - qty_out')), 4);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function fifoRate(array $attributes, float $qtyOut): float
    {
        $rows = StockLedger::query()
            ->where('company_id', $attributes['company_id'])
            ->where('warehouse_id', $attributes['warehouse_id'])
            ->where('stock_type', $attributes['stock_type'])
            ->where('item_id', $attributes['item_id'])
            ->when(! empty($attributes['lot_id']), fn ($q) => $q->where('lot_id', $attributes['lot_id']), fn ($q) => $q->whereNull('lot_id'))
            ->orderBy('id')
            ->get(['qty_in', 'qty_out', 'rate']);

        $layers = [];
        foreach ($rows as $row) {
            if ((float) $row->qty_in > 0) {
                $layers[] = ['qty' => (float) $row->qty_in, 'rate' => (float) $row->rate];
            }
            $consume = (float) $row->qty_out;
            while ($consume > 0 && $layers !== []) {
                $take = min($consume, $layers[0]['qty']);
                $layers[0]['qty'] -= $take;
                $consume -= $take;
                if ($layers[0]['qty'] <= 0.0001) {
                    array_shift($layers);
                }
            }
        }

        $need = $qtyOut;
        $value = 0.0;
        foreach ($layers as $layer) {
            if ($need <= 0) {
                break;
            }
            $take = min($need, $layer['qty']);
            $value += $take * $layer['rate'];
            $need -= $take;
        }

        if ($qtyOut <= 0) {
            return 0.0;
        }

        return round($value / $qtyOut, 4);
    }
}
