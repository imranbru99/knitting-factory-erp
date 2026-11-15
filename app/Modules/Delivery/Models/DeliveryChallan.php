<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class DeliveryChallan extends ErpModel
{
    public string $documentType = 'DC';

    protected $table = 'delivery_challans';

    public function packing_list(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Delivery\Models\PackingList::class, 'packing_list_id');
    }
    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Delivery\Models\DeliveryChallanLine::class);
    }
}
