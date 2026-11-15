<?php

declare(strict_types=1);

namespace App\Modules\Quality\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class FinishedInspectionDefect extends ErpModel
{
    protected function casts(): array
    {
        return [
            'position_m' => 'decimal:4',
        ];
    }

    protected $table = 'finished_inspection_defects';

    public function finished_inspection(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Quality\Models\FinishedInspection::class, 'finished_inspection_id');
    }
    public function defect(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Defect::class, 'defect_id');
    }
}
