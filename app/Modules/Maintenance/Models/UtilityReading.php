<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class UtilityReading extends ErpModel
{
    protected function casts(): array
    {
        return [
            'read_on' => 'date',
            'reading' => 'decimal:4',
            'consumption' => 'decimal:4',
            'cost' => 'decimal:2',
            'production_kg' => 'decimal:4',
        ];
    }

    protected $table = 'utility_readings';

    public function utility_meter(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Maintenance\Models\UtilityMeter::class, 'utility_meter_id');
    }
    public function shift(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Shift::class, 'shift_id');
    }
}
