<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class GreyInspection extends ErpModel
{
    protected function casts(): array
    {
        return [
            'gsm' => 'decimal:4',
            'dia' => 'decimal:4',
            'points' => 'decimal:4',
            'length_m' => 'decimal:4',
        ];
    }

    protected $table = 'grey_inspections';

    public function roll(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Knitting\Models\Roll::class, 'roll_id');
    }
    public function inspector(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Employee::class, 'inspector_id');
    }
    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Knitting\Models\GreyInspectionDefect::class);
    }
}
