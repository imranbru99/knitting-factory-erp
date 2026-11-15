<?php

declare(strict_types=1);

namespace App\Modules\Masters\Models;

use App\Modules\Support\ErpModel;
class Party extends ErpModel
{
    protected function casts(): array
    {
        return [
            'credit_limit' => 'decimal:2',
            'rating' => 'decimal:4',
            'is_blacklisted' => 'boolean',
            'documents_expire_on' => 'date',
        ];
    }

    protected $table = 'parties';


}
