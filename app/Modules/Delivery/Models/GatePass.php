<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Models;

use App\Modules\Support\ErpModel;
class GatePass extends ErpModel
{
    public string $documentType = 'GP';

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
        ];
    }

    protected $table = 'gate_passes';


}
