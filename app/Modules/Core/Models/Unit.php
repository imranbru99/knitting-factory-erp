<?php

declare(strict_types=1);

namespace App\Modules\Core\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Unit extends ErpModel
{
    protected $table = 'units';

    public function company(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Company::class, 'company_id');
    }
}
