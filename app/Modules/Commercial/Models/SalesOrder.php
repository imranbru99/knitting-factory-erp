<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class SalesOrder extends ErpModel
{
    public string $documentType = 'SO';

    protected function casts(): array
    {
        return [
            'order_date' => 'date',
            'delivery_date' => 'date',
            'tolerance_pct' => 'decimal:4',
        ];
    }

    protected $table = 'sales_orders';

    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
    public function unit(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Unit::class, 'unit_id');
    }
    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Commercial\Models\Inquiry::class, 'inquiry_id');
    }
    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Commercial\Models\SalesOrderLine::class);
    }
}
