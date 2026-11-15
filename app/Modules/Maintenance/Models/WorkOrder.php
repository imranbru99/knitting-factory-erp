<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class WorkOrder extends ErpModel
{
    public string $documentType = 'WO';

    protected function casts(): array
    {
        return [
            'opened_at' => 'datetime',
            'closed_at' => 'datetime',
            'cost' => 'decimal:2',
        ];
    }

    protected $table = 'work_orders';

    public function asset(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Maintenance\Models\Asset::class, 'asset_id');
    }
    public function machine(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Knitting\Models\Machine::class, 'machine_id');
    }
}
