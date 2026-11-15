<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class DeliveryChallanLine extends ErpModel
{
    protected function casts(): array
    {
        return [
            'kg' => 'decimal:4',
        ];
    }

    protected $table = 'delivery_challan_lines';

    public function delivery_challan(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Delivery\Models\DeliveryChallan::class, 'delivery_challan_id');
    }
    public function roll(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Knitting\Models\Roll::class, 'roll_id');
    }
}
