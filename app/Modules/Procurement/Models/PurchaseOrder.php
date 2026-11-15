<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class PurchaseOrder extends ErpModel
{
    public string $documentType = 'PO';

    protected function casts(): array
    {
        return [
            'order_date' => 'date',
            'expected_on' => 'date',
        ];
    }

    protected $table = 'purchase_orders';

    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
    public function requisition(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Procurement\Models\Requisition::class, 'requisition_id');
    }
    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Procurement\Models\PurchaseOrderLine::class);
    }
}
