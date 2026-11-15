<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Recipe extends ErpModel
{
    protected function casts(): array
    {
        return [
            'liquor_ratio' => 'decimal:4',
            'cost_per_kg' => 'decimal:2',
        ];
    }

    protected $table = 'recipes';

    public function color(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Color::class, 'color_id');
    }
    public function fabric_item(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\FabricItem::class, 'fabric_item_id');
    }
    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Dyeing\Models\RecipeLine::class);
    }
}
