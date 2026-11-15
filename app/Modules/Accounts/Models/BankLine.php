<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class BankLine extends ErpModel
{
    protected function casts(): array
    {
        return [
            'txn_date' => 'date',
            'amount' => 'decimal:2',
            'matched' => 'boolean',
        ];
    }

    protected $table = 'bank_lines';

    public function bank_account(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Accounts\Models\BankAccount::class, 'bank_account_id');
    }
}
