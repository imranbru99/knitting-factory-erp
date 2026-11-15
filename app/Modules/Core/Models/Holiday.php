<?php

declare(strict_types=1);

namespace App\Modules\Core\Models;

use App\Modules\Support\ErpModel;
class Holiday extends ErpModel
{
    protected function casts(): array
    {
        return [
            'holiday_date' => 'date',
        ];
    }

    protected $table = 'holidays';


}
