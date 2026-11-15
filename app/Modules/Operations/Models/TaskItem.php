<?php

declare(strict_types=1);

namespace App\Modules\Operations\Models;

use App\Modules\Support\ErpModel;
class TaskItem extends ErpModel
{
    protected function casts(): array
    {
        return [
            'due_at' => 'datetime',
        ];
    }

    protected $table = 'tasks';


}
