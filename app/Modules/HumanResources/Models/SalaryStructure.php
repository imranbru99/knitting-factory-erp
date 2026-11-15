<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class SalaryStructure extends ErpModel
{
    protected function casts(): array
    {
        return [
            'basic' => 'decimal:2',
            'house_rent' => 'decimal:2',
            'medical' => 'decimal:2',
            'conveyance' => 'decimal:2',
            'attendance_bonus' => 'decimal:2',
        ];
    }

    protected $table = 'salary_structures';

    public function employee(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Employee::class, 'employee_id');
    }
}
