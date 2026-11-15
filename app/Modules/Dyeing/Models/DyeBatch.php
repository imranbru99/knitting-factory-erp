<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class DyeBatch extends ErpModel
{
    public string $documentType = 'BAT';

    protected function casts(): array
    {
        return [
            'input_kg' => 'decimal:4',
            'output_kg' => 'decimal:4',
            'process_loss_pct' => 'decimal:4',
            'shade_de' => 'decimal:4',
            'is_subcontract' => 'boolean',
        ];
    }

    protected $table = 'dye_batches';

    public function dye_machine(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Dyeing\Models\DyeMachine::class, 'dye_machine_id');
    }
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Dyeing\Models\Recipe::class, 'recipe_id');
    }
    public function color(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Color::class, 'color_id');
    }
    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
}
