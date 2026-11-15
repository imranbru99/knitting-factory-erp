<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class SupplierBill extends ErpModel
{
    public string $documentType = 'BILL';

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    protected $table = 'supplier_bills';

    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
    public function purchase_order(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Procurement\Models\PurchaseOrder::class, 'purchase_order_id');
    }
    public function goods_receipt(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Procurement\Models\GoodsReceipt::class, 'goods_receipt_id');
    }
    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Procurement\Models\SupplierBillLine::class);
    }
}
