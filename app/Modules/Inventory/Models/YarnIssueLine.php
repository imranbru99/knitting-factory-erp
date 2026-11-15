<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class YarnIssueLine extends ErpModel
{
    protected function casts(): array
    {
        return [
            'qty' => 'decimal:4',
            'approved_mix' => 'boolean',
        ];
    }

    protected $table = 'yarn_issue_lines';

    public function yarn_issue(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Inventory\Models\YarnIssue::class, 'yarn_issue_id');
    }
    public function yarn_lot(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Procurement\Models\YarnLot::class, 'yarn_lot_id');
    }
    public function yarn_item(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\YarnItem::class, 'yarn_item_id');
    }
}
