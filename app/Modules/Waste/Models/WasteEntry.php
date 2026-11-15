<?php

declare(strict_types=1);

namespace App\Modules\Waste\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class WasteEntry extends ErpModel
{
    public string $documentType = 'WST';

    protected function casts(): array
    {
        return [
            'qty_kg' => 'decimal:4',
            'rate' => 'decimal:2',
            'value' => 'decimal:2',
        ];
    }

    protected $table = 'waste_entries';

    public function sales_order(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Commercial\Models\SalesOrder::class, 'sales_order_id');
    }
    public function machine(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Knitting\Models\Machine::class, 'machine_id');
    }
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Warehouse::class, 'warehouse_id');
    }
}
