<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class SalesOrderLine extends ErpModel
{
    protected function casts(): array
    {
        return [
            'gsm' => 'decimal:4',
            'dia' => 'decimal:4',
            'qty_kg' => 'decimal:4',
            'qty_yd' => 'decimal:4',
            'rate' => 'decimal:2',
            'delivery_date' => 'date',
        ];
    }

    protected $table = 'sales_order_lines';

    public function sales_order(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Commercial\Models\SalesOrder::class, 'sales_order_id');
    }
    public function fabric_item(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\FabricItem::class, 'fabric_item_id');
    }
    public function color(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Color::class, 'color_id');
    }
}
