<?php

declare(strict_types=1);

namespace App\Modules\Masters\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class FabricItem extends ErpModel
{
    protected function casts(): array
    {
        return [
            'gsm_target' => 'decimal:4',
            'gsm_min' => 'decimal:4',
            'gsm_max' => 'decimal:4',
            'dia' => 'decimal:4',
            'gauge' => 'decimal:4',
            'stitch_length' => 'decimal:4',
        ];
    }

    protected $table = 'fabric_items';

    public function fabric_construction(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\FabricConstruction::class, 'fabric_construction_id');
    }
    public function color(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Color::class, 'color_id');
    }
}
