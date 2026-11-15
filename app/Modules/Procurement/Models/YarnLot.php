<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class YarnLot extends ErpModel
{
    protected function casts(): array
    {
        return [
            'received_on' => 'date',
            'csp' => 'decimal:4',
            'u_percent' => 'decimal:4',
            'moisture' => 'decimal:4',
            'net_kg' => 'decimal:4',
        ];
    }

    protected $table = 'yarn_lots';

    public function yarn_item(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\YarnItem::class, 'yarn_item_id');
    }
    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Warehouse::class, 'warehouse_id');
    }
}
