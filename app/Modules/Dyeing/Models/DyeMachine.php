<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Models;

use App\Modules\Support\ErpModel;
class DyeMachine extends ErpModel
{
    protected function casts(): array
    {
        return [
            'capacity_kg' => 'decimal:4',
        ];
    }

    protected $table = 'dye_machines';


}
