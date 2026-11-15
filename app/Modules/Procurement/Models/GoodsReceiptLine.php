<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class GoodsReceiptLine extends ErpModel
{
    protected function casts(): array
    {
        return [
            'challan_weight' => 'decimal:4',
            'actual_weight' => 'decimal:4',
            'shortage' => 'decimal:4',
        ];
    }

    protected $table = 'goods_receipt_lines';

    public function goods_receipt(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Procurement\Models\GoodsReceipt::class, 'goods_receipt_id');
    }
    public function purchase_order_line(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Procurement\Models\PurchaseOrderLine::class, 'purchase_order_line_id');
    }
    public function yarn_item(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\YarnItem::class, 'yarn_item_id');
    }
}
