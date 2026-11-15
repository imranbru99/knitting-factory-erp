<?php

declare(strict_types=1);

namespace App\Modules\Core\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Warehouse extends ErpModel
{
    protected $table = 'warehouses';

    public function unit(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Unit::class, 'unit_id');
    }
}
