<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Budget extends ErpModel
{
    protected $table = 'budgets';

    public function financial_year(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\FinancialYear::class, 'financial_year_id');
    }
    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Accounts\Models\BudgetLine::class);
    }
}
