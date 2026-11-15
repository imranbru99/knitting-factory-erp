<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class LeaveRequest extends ErpModel
{
    protected function casts(): array
    {
        return [
            'starts_on' => 'date',
            'ends_on' => 'date',
        ];
    }

    protected $table = 'leave_requests';

    public function employee(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Employee::class, 'employee_id');
    }
    public function leave_type(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\HumanResources\Models\LeaveType::class, 'leave_type_id');
    }
}
