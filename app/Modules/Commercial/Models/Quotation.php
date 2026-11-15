<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Quotation extends ErpModel
{
    public string $documentType = 'QT';

    protected function casts(): array
    {
        return [
            'valid_until' => 'date',
        ];
    }

    protected $table = 'quotations';

    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
    public function cost_sheet(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Commercial\Models\CostSheet::class, 'cost_sheet_id');
    }
    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Commercial\Models\QuotationLine::class);
    }
}
