<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Rfq extends ErpModel
{
    public string $documentType = 'RFQ';

    protected function casts(): array
    {
        return [
            'due_on' => 'date',
        ];
    }

    protected $table = 'rfqs';

    public function requisition(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Procurement\Models\Requisition::class, 'requisition_id');
    }
    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Procurement\Models\RfqLine::class);
    }
}
