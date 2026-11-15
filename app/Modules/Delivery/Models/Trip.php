<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Trip extends ErpModel
{
    protected function casts(): array
    {
        return [
            'fuel_cost' => 'decimal:2',
            'started_on' => 'date',
        ];
    }

    protected $table = 'trips';

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Delivery\Models\Vehicle::class, 'vehicle_id');
    }
    public function delivery_challan(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Delivery\Models\DeliveryChallan::class, 'delivery_challan_id');
    }
}
