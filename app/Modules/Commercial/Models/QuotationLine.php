<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class QuotationLine extends ErpModel
{
    protected function casts(): array
    {
        return [
            'qty' => 'decimal:4',
            'rate' => 'decimal:2',
        ];
    }

    protected $table = 'quotation_lines';

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Commercial\Models\Quotation::class, 'quotation_id');
    }
    public function fabric_item(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\FabricItem::class, 'fabric_item_id');
    }
    public function color(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Color::class, 'color_id');
    }
}
