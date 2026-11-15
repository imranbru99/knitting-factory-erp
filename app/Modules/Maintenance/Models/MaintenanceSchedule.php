<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class MaintenanceSchedule extends ErpModel
{
    protected function casts(): array
    {
        return [
            'last_done_on' => 'date',
            'next_due_on' => 'date',
        ];
    }

    protected $table = 'maintenance_schedules';

    public function asset(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Maintenance\Models\Asset::class, 'asset_id');
    }
}
