<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class CreditNote extends ErpModel
{
    public string $documentType = 'CN';

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    protected $table = 'credit_notes';

    public function sales_invoice(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Delivery\Models\SalesInvoice::class, 'sales_invoice_id');
    }
}
