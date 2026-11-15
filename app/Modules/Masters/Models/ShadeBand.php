<?php

declare(strict_types=1);

namespace App\Modules\Masters\Models;

use App\Modules\Support\ErpModel;
class ShadeBand extends ErpModel
{
    protected function casts(): array
    {
        return [
            'delta_e_max' => 'decimal:4',
        ];
    }

    protected $table = 'shade_bands';


}
