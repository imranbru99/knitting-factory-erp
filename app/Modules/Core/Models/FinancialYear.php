<?php

declare(strict_types=1);

namespace App\Modules\Core\Models;

use App\Modules\Support\ErpModel;
class FinancialYear extends ErpModel
{
    protected function casts(): array
    {
        return [
            'starts_on' => 'date',
            'ends_on' => 'date',
            'is_current' => 'boolean',
            'is_locked' => 'boolean',
        ];
    }

    protected $table = 'financial_years';


}
