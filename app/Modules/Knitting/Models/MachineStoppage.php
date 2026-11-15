<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class MachineStoppage extends ErpModel
{
    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
        ];
    }

    protected $table = 'machine_stoppages';

    public function machine(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Knitting\Models\Machine::class, 'machine_id');
    }
    public function operator(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Employee::class, 'operator_id');
    }
}
