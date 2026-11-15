<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Models;

use App\Modules\Support\ErpModel;
class GateLog extends ErpModel
{
    protected function casts(): array
    {
        return [
            'in_at' => 'datetime',
            'out_at' => 'datetime',
        ];
    }

    protected $table = 'gate_logs';


}
