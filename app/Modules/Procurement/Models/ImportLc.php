<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ImportLc extends ErpModel
{
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'margin' => 'decimal:2',
            'maturity_on' => 'date',
        ];
    }

    protected $table = 'import_lcs';

    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
}
