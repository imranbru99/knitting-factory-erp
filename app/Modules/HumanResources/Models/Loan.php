<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Loan extends ErpModel
{
    protected function casts(): array
    {
        return [
            'principal' => 'decimal:2',
            'balance' => 'decimal:2',
            'installment' => 'decimal:2',
        ];
    }

    protected $table = 'loans';

    public function employee(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Employee::class, 'employee_id');
    }
}
