<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Payslip extends ErpModel
{
    protected function casts(): array
    {
        return [
            'gross' => 'decimal:2',
            'deductions' => 'decimal:2',
            'net' => 'decimal:2',
        ];
    }

    protected $table = 'payslips';

    public function payroll_run(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\HumanResources\Models\PayrollRun::class, 'payroll_run_id');
    }
    public function employee(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Employee::class, 'employee_id');
    }
    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\HumanResources\Models\PayslipLine::class);
    }
}
