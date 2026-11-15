<?php

declare(strict_types=1);

namespace App\Modules\Masters\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Employee extends ErpModel
{
    protected function casts(): array
    {
        return [
            'joining_date' => 'date',
            'basic_salary' => 'decimal:2',
            'is_operator' => 'boolean',
        ];
    }

    protected $table = 'employees';

    public function department(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Department::class, 'department_id');
    }
    public function shift(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Shift::class, 'shift_id');
    }
}
