<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ChemicalIssue extends ErpModel
{
    protected function casts(): array
    {
        return [
            'qty' => 'decimal:4',
            'recipe_qty' => 'decimal:4',
        ];
    }

    protected $table = 'chemical_issues';

    public function dye_batch(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Dyeing\Models\DyeBatch::class, 'dye_batch_id');
    }
}
