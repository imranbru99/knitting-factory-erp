<?php

declare(strict_types=1);

namespace App\Modules\Quality\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class FinishedInspection extends ErpModel
{
    protected function casts(): array
    {
        return [
            'points_per_100' => 'decimal:4',
            'length_yd' => 'decimal:4',
            'width_in' => 'decimal:4',
        ];
    }

    protected $table = 'finished_inspections';

    public function roll(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Knitting\Models\Roll::class, 'roll_id');
    }
    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Quality\Models\FinishedInspectionDefect::class);
    }
}
