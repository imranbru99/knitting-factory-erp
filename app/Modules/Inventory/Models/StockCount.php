<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class StockCount extends ErpModel
{
    public string $documentType = 'SC';

    protected function casts(): array
    {
        return [
            'counted_on' => 'date',
        ];
    }

    protected $table = 'stock_counts';

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Warehouse::class, 'warehouse_id');
    }
    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Inventory\Models\StockCountLine::class);
    }
}
