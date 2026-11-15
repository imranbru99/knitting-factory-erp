<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PayslipLine extends ErpModel
{
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    protected $table = 'payslip_lines';

    public function payslip(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\HumanResources\Models\Payslip::class, 'payslip_id');
    }
}
