<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class SalesInvoiceLine extends ErpModel
{
    protected function casts(): array
    {
        return [
            'qty' => 'decimal:4',
            'rate' => 'decimal:2',
            'amount' => 'decimal:2',
        ];
    }

    protected $table = 'sales_invoice_lines';

    public function sales_invoice(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Delivery\Models\SalesInvoice::class, 'sales_invoice_id');
    }
}
