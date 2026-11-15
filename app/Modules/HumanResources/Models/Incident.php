<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Incident extends ErpModel
{
    protected function casts(): array
    {
        return [
            'occurred_on' => 'date',
        ];
    }

    protected $table = 'incidents';

    public function employee(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Employee::class, 'employee_id');
    }
}
