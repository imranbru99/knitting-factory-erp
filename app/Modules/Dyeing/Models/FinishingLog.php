<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class FinishingLog extends ErpModel
{
    protected function casts(): array
    {
        return [
            'gsm_after' => 'decimal:4',
            'dia_after' => 'decimal:4',
            'shrinkage_l' => 'decimal:4',
            'shrinkage_w' => 'decimal:4',
            'done_at' => 'datetime',
        ];
    }

    protected $table = 'finishing_logs';

    public function dye_batch(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Dyeing\Models\DyeBatch::class, 'dye_batch_id');
    }
}
