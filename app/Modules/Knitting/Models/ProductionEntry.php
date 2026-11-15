<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ProductionEntry extends ErpModel
{
    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
            'produced_kg' => 'decimal:4',
            'rpm_actual' => 'decimal:4',
        ];
    }

    protected $table = 'production_entries';

    public function machine(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Knitting\Models\Machine::class, 'machine_id');
    }
    public function shift(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Shift::class, 'shift_id');
    }
    public function operator(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Employee::class, 'operator_id');
    }
    public function knitting_program(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Knitting\Models\KnittingProgram::class, 'knitting_program_id');
    }
}
