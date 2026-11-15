<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class CostSheet extends ErpModel
{
    public string $documentType = 'CST';

    protected function casts(): array
    {
        return [
            'yarn_rate' => 'decimal:2',
            'knitting_charge' => 'decimal:2',
            'dyeing_charge' => 'decimal:2',
            'process_loss_pct' => 'decimal:4',
            'wastage_pct' => 'decimal:4',
            'overhead_pct' => 'decimal:4',
            'finance_pct' => 'decimal:4',
            'profit_pct' => 'decimal:4',
            'cost_per_kg' => 'decimal:2',
            'cost_per_yard' => 'decimal:2',
            'quoted_rate' => 'decimal:2',
        ];
    }

    protected $table = 'cost_sheets';

    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
    public function fabric_item(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\FabricItem::class, 'fabric_item_id');
    }
}
