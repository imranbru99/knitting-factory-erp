<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class AttendanceDay extends ErpModel
{
    protected function casts(): array
    {
        return [
            'work_date' => 'date',
            'in_at' => 'datetime',
            'out_at' => 'datetime',
        ];
    }

    protected $table = 'attendance_days';

    public function employee(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Employee::class, 'employee_id');
    }
}
