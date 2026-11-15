<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ReorderRule extends ErpModel
{
    protected function casts(): array
    {
        return [
            'min_qty' => 'decimal:4',
            'max_qty' => 'decimal:4',
        ];
    }

    protected $table = 'reorder_rules';

    public function yarn_item(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\YarnItem::class, 'yarn_item_id');
    }
}
