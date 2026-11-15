<?php

declare(strict_types=1);

namespace App\Modules\Core\Models;

use App\Modules\Support\ErpModel;
class Shift extends ErpModel
{
    protected function casts(): array
    {
        return [
            'is_night' => 'boolean',
        ];
    }

    protected $table = 'shifts';


}
