<?php

declare(strict_types=1);

namespace App\Modules\Quality\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class LabTest extends ErpModel
{
    protected function casts(): array
    {
        return [
            'passed' => 'boolean',
        ];
    }

    protected $table = 'lab_tests';

    public function roll(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Knitting\Models\Roll::class, 'roll_id');
    }
    public function dye_batch(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Dyeing\Models\DyeBatch::class, 'dye_batch_id');
    }
}
