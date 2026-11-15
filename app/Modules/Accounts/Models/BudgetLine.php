<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class BudgetLine extends ErpModel
{
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    protected $table = 'budget_lines';

    public function budget(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Accounts\Models\Budget::class, 'budget_id');
    }
    public function account(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Accounts\Models\Account::class, 'account_id');
    }
}
