<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Inquiry extends ErpModel
{
    public string $documentType = 'INQ';

    protected function casts(): array
    {
        return [
            'qty_kg' => 'decimal:4',
            'target_date' => 'date',
        ];
    }

    protected $table = 'inquiries';

    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
    public function fabric_item(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\FabricItem::class, 'fabric_item_id');
    }
}
