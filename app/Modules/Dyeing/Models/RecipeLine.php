<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class RecipeLine extends ErpModel
{
    protected function casts(): array
    {
        return [
            'gpl' => 'decimal:4',
            'cost' => 'decimal:2',
        ];
    }

    protected $table = 'recipe_lines';

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Dyeing\Models\Recipe::class, 'recipe_id');
    }
}
