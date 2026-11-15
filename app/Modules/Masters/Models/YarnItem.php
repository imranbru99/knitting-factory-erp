<?php

declare(strict_types=1);

namespace App\Modules\Masters\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class YarnItem extends ErpModel
{
    protected function casts(): array
    {
        return [
            'reorder_level' => 'decimal:4',
            'min_qty' => 'decimal:4',
            'max_qty' => 'decimal:4',
            'last_rate' => 'decimal:2',
        ];
    }

    protected $table = 'yarn_items';

    public function yarn_count(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\YarnCount::class, 'yarn_count_id');
    }
    public function yarn_type(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\YarnType::class, 'yarn_type_id');
    }
}
