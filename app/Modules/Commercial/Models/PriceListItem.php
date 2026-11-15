<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PriceListItem extends ErpModel
{
    protected function casts(): array
    {
        return [
            'rate' => 'decimal:2',
        ];
    }

    protected $table = 'price_list_items';

    public function price_list(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Commercial\Models\PriceList::class, 'price_list_id');
    }
    public function fabric_item(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\FabricItem::class, 'fabric_item_id');
    }
}
