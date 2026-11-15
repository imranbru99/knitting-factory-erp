<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class GoodsReceipt extends ErpModel
{
    public string $documentType = 'GRN';

    protected function casts(): array
    {
        return [
            'received_on' => 'date',
        ];
    }

    protected $table = 'goods_receipts';

    public function purchase_order(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Procurement\Models\PurchaseOrder::class, 'purchase_order_id');
    }
    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Warehouse::class, 'warehouse_id');
    }
    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Procurement\Models\GoodsReceiptLine::class);
    }
}
