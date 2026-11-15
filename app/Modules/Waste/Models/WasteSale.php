<?php

declare(strict_types=1);

namespace App\Modules\Waste\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class WasteSale extends ErpModel
{
    public string $documentType = 'WSL';

    protected function casts(): array
    {
        return [
            'qty_kg' => 'decimal:4',
            'amount' => 'decimal:2',
        ];
    }

    protected $table = 'waste_sales';

    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
    public function gate_pass(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Delivery\Models\GatePass::class, 'gate_pass_id');
    }
}
