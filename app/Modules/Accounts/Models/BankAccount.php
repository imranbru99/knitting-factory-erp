<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class BankAccount extends ErpModel
{
    protected $table = 'bank_accounts';

    public function glAccount(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Accounts\Models\Account::class, 'gl_account_id');
    }
}
