<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class BomLine extends ErpModel
{
    protected function casts(): array
    {
        return [
            'ratio_pct' => 'decimal:4',
            'requirement_kg' => 'decimal:4',
            'is_lycra' => 'boolean',
        ];
    }

    protected $table = 'bom_lines';

    public function bom(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Commercial\Models\Bom::class, 'bom_id');
    }
    public function yarn_item(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\YarnItem::class, 'yarn_item_id');
    }
}
