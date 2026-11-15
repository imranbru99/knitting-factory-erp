<?php

declare(strict_types=1);

namespace App\Modules\Core\Models;

use App\Modules\Support\ErpModel;
class TaxRule extends ErpModel
{
    protected function casts(): array
    {
        return [
            'rate' => 'decimal:4',
        ];
    }

    protected $table = 'tax_rules';


}
