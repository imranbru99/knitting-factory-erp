<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class SalesInvoice extends ErpModel
{
    public string $documentType = 'INV';

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'vat' => 'decimal:2',
            'total' => 'decimal:2',
            'invoice_date' => 'date',
            'due_date' => 'date',
        ];
    }

    protected $table = 'sales_invoices';

    public function delivery_challan(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Delivery\Models\DeliveryChallan::class, 'delivery_challan_id');
    }
    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Delivery\Models\SalesInvoiceLine::class);
    }
}
