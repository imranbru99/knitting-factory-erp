<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Shipment extends ErpModel
{
    protected function casts(): array
    {
        return [
            'eta' => 'date',
            'duty' => 'decimal:2',
            'freight' => 'decimal:2',
            'landed_cost' => 'decimal:2',
        ];
    }

    protected $table = 'shipments';

    public function import_lc(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Procurement\Models\ImportLc::class, 'import_lc_id');
    }
}
