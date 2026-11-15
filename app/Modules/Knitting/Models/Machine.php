<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Machine extends ErpModel
{
    protected function casts(): array
    {
        return [
            'dia' => 'decimal:4',
            'gauge' => 'decimal:4',
            'rpm' => 'decimal:4',
            'capacity_kg_shift' => 'decimal:4',
            'installed_on' => 'date',
        ];
    }

    protected $table = 'machines';

    public function unit(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Unit::class, 'unit_id');
    }
    public function floor(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Floor::class, 'floor_id');
    }
    public function machine_brand(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\MachineBrand::class, 'machine_brand_id');
    }
}
