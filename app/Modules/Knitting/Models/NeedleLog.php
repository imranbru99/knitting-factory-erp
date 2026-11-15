<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class NeedleLog extends ErpModel
{
    protected function casts(): array
    {
        return [
            'changed_on' => 'date',
        ];
    }

    protected $table = 'needle_logs';

    public function machine(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Knitting\Models\Machine::class, 'machine_id');
    }
}
