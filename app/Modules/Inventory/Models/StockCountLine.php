<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class StockCountLine extends ErpModel
{
    protected function casts(): array
    {
        return [
            'book_qty' => 'decimal:4',
            'physical_qty' => 'decimal:4',
            'variance' => 'decimal:4',
        ];
    }

    protected $table = 'stock_count_lines';

    public function stock_count(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Inventory\Models\StockCount::class, 'stock_count_id');
    }
}
