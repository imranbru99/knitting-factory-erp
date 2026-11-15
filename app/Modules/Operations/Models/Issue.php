<?php

declare(strict_types=1);

namespace App\Modules\Operations\Models;

use App\Modules\Support\ErpModel;
class Issue extends ErpModel
{
    protected function casts(): array
    {
        return [
            'sla_due_at' => 'datetime',
        ];
    }

    protected $table = 'issues';


}
