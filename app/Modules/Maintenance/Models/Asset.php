<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Asset extends ErpModel
{
    protected function casts(): array
    {
        return [
            'cost' => 'decimal:2',
            'installed_on' => 'date',
        ];
    }

    protected $table = 'assets';

    public function machine(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Knitting\Models\Machine::class, 'machine_id');
    }
}
