<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Models;

use App\Modules\Support\ErpModel;
class PeriodLock extends ErpModel
{
    protected function casts(): array
    {
        return [
            'locked_at' => 'datetime',
        ];
    }

    protected $table = 'period_locks';


}
