<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class SubcontractJob extends ErpModel
{
    public string $documentType = 'SUB';

    protected function casts(): array
    {
        return [
            'yarn_sent_kg' => 'decimal:4',
            'rolls_received_kg' => 'decimal:4',
            'charge_per_kg' => 'decimal:2',
        ];
    }

    protected $table = 'subcontract_jobs';

    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
    public function sales_order(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Commercial\Models\SalesOrder::class, 'sales_order_id');
    }
}
