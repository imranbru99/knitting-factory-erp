<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class RfqLine extends ErpModel
{
    protected function casts(): array
    {
        return [
            'qty' => 'decimal:4',
        ];
    }

    protected $table = 'rfq_lines';

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Procurement\Models\Rfq::class, 'rfq_id');
    }
    public function yarn_item(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\YarnItem::class, 'yarn_item_id');
    }
}
