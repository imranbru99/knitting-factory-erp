<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class PriceList extends ErpModel
{
    protected $table = 'price_lists';

    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Commercial\Models\PriceListItem::class);
    }
}
