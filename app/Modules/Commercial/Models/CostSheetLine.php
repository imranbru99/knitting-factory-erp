<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class CostSheetLine extends ErpModel
{
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    protected $table = 'cost_sheet_lines';

    public function cost_sheet(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Commercial\Models\CostSheet::class, 'cost_sheet_id');
    }
}
