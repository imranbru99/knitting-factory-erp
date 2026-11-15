<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class KnittingProgramYarn extends ErpModel
{
    protected function casts(): array
    {
        return [
            'ratio_pct' => 'decimal:4',
        ];
    }

    protected $table = 'knitting_program_yarns';

    public function knitting_program(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Knitting\Models\KnittingProgram::class, 'knitting_program_id');
    }
    public function yarn_lot(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Procurement\Models\YarnLot::class, 'yarn_lot_id');
    }
    public function yarn_item(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\YarnItem::class, 'yarn_item_id');
    }
}
