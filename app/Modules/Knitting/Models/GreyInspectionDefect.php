<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class GreyInspectionDefect extends ErpModel
{
    protected function casts(): array
    {
        return [
            'position_m' => 'decimal:4',
        ];
    }

    protected $table = 'grey_inspection_defects';

    public function grey_inspection(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Knitting\Models\GreyInspection::class, 'grey_inspection_id');
    }
    public function defect(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Defect::class, 'defect_id');
    }
}
