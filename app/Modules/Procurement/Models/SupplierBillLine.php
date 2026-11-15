<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class SupplierBillLine extends ErpModel
{
    protected function casts(): array
    {
        return [
            'qty' => 'decimal:4',
            'amount' => 'decimal:2',
        ];
    }

    protected $table = 'supplier_bill_lines';

    public function supplier_bill(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Procurement\Models\SupplierBill::class, 'supplier_bill_id');
    }
}
