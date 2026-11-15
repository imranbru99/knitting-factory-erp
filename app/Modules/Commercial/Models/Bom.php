<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Bom extends ErpModel
{
    public string $documentType = 'BOM';

    protected function casts(): array
    {
        return [
            'process_loss_pct' => 'decimal:4',
            'wastage_pct' => 'decimal:4',
        ];
    }

    protected $table = 'boms';

    public function sales_order(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Commercial\Models\SalesOrder::class, 'sales_order_id');
    }
    public function fabric_item(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\FabricItem::class, 'fabric_item_id');
    }
    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Commercial\Models\BomLine::class);
    }
}
