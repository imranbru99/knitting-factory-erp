<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class DyeBatchRoll extends ErpModel
{
    protected function casts(): array
    {
        return [
            'kg' => 'decimal:4',
        ];
    }

    protected $table = 'dye_batch_rolls';

    public function dye_batch(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Dyeing\Models\DyeBatch::class, 'dye_batch_id');
    }
    public function roll(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Knitting\Models\Roll::class, 'roll_id');
    }
}
