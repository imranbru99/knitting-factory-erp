<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class RfqQuote extends ErpModel
{
    protected function casts(): array
    {
        return [
            'rate' => 'decimal:2',
            'score' => 'decimal:4',
        ];
    }

    protected $table = 'rfq_quotes';

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Procurement\Models\Rfq::class, 'rfq_id');
    }
    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
    public function yarn_item(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\YarnItem::class, 'yarn_item_id');
    }
}
