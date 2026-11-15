<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Account extends ErpModel
{
    protected $table = 'accounts';

    public function parent(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Accounts\Models\Account::class, 'parent_id');
    }
}
