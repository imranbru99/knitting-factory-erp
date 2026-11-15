<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ShadeMatch extends ErpModel
{
    protected function casts(): array
    {
        return [
            'l_star' => 'decimal:4',
            'a_star' => 'decimal:4',
            'b_star' => 'decimal:4',
            'delta_e' => 'decimal:4',
            'approved' => 'boolean',
        ];
    }

    protected $table = 'shade_matches';

    public function dye_batch(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Dyeing\Models\DyeBatch::class, 'dye_batch_id');
    }
}
