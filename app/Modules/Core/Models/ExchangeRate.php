<?php

declare(strict_types=1);

namespace App\Modules\Core\Models;

use App\Modules\Support\ErpModel;
class ExchangeRate extends ErpModel
{
    protected function casts(): array
    {
        return [
            'rate_date' => 'date',
            'rate_to_bdt' => 'decimal:4',
        ];
    }

    protected $table = 'exchange_rates';


}
