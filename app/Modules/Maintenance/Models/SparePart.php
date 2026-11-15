<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Models;

use App\Modules\Support\ErpModel;
class SparePart extends ErpModel
{
    protected function casts(): array
    {
        return [
            'min_qty' => 'decimal:4',
            'max_qty' => 'decimal:4',
            'rate' => 'decimal:2',
        ];
    }

    protected $table = 'spare_parts';


}
