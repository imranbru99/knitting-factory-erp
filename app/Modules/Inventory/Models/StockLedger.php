<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Models;

use App\Modules\Support\AppendOnlyModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class StockLedger extends AppendOnlyModel
{
    protected function casts(): array
    {
        return [
            'qty_in' => 'decimal:4',
            'qty_out' => 'decimal:4',
            'balance_qty' => 'decimal:4',
            'rate' => 'decimal:2',
            'amount' => 'decimal:2',
            'moved_at' => 'datetime',
        ];
    }

    protected $table = 'stock_ledgers';

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Warehouse::class, 'warehouse_id');
    }
    public function unit(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Unit::class, 'unit_id');
    }
}
