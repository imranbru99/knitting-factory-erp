<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class DisciplinaryAction extends ErpModel
{
    protected function casts(): array
    {
        return [
            'issued_on' => 'date',
        ];
    }

    protected $table = 'disciplinary_actions';

    public function employee(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Employee::class, 'employee_id');
    }
}
