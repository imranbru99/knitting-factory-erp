<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class DebitNote extends ErpModel
{
    public string $documentType = 'DN';

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    protected $table = 'debit_notes';

    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
    public function supplier_bill(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Procurement\Models\SupplierBill::class, 'supplier_bill_id');
    }
}
