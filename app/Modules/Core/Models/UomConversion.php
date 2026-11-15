<?php

declare(strict_types=1);

namespace App\Modules\Core\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class UomConversion extends ErpModel
{
    protected bool $scopesCompany = false;

    protected function casts(): array
    {
        return [
            'factor' => 'decimal:4',
        ];
    }

    protected $table = 'uom_conversions';

    public function fromUom(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Uom::class, 'from_uom_id');
    }
    public function toUom(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Uom::class, 'to_uom_id');
    }
}
