<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class YarnTransfer extends ErpModel
{
    public string $documentType = 'YTR';

    protected function casts(): array
    {
        return [
            'qty' => 'decimal:4',
        ];
    }

    protected $table = 'yarn_transfers';

    public function fromOrder(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Commercial\Models\SalesOrder::class, 'from_sales_order_id');
    }
    public function toOrder(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Commercial\Models\SalesOrder::class, 'to_sales_order_id');
    }
    public function yarn_lot(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Procurement\Models\YarnLot::class, 'yarn_lot_id');
    }
}
