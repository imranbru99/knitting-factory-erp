<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class PackingList extends ErpModel
{
    public string $documentType = 'PL';

    protected function casts(): array
    {
        return [
            'net_kg' => 'decimal:4',
            'gross_kg' => 'decimal:4',
            'yards' => 'decimal:4',
        ];
    }

    protected $table = 'packing_lists';

    public function sales_order(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Commercial\Models\SalesOrder::class, 'sales_order_id');
    }
    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Delivery\Models\PackingListLine::class);
    }
}
