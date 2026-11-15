<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Vehicle extends ErpModel
{
    protected function casts(): array
    {
        return [
            'capacity_kg' => 'decimal:4',
        ];
    }

    protected $table = 'vehicles';

    public function transporter(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'transporter_id');
    }
}
