<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PackingListLine extends ErpModel
{
    protected function casts(): array
    {
        return [
            'net_kg' => 'decimal:4',
            'yards' => 'decimal:4',
        ];
    }

    protected $table = 'packing_list_lines';

    public function packing_list(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Delivery\Models\PackingList::class, 'packing_list_id');
    }
    public function roll(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Knitting\Models\Roll::class, 'roll_id');
    }
}
