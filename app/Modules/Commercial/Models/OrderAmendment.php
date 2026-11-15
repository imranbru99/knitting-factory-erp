<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class OrderAmendment extends ErpModel
{
    protected function casts(): array
    {
        return [
            'changes' => 'array',
            'revised_delivery' => 'date',
        ];
    }

    protected $table = 'order_amendments';

    public function sales_order(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Commercial\Models\SalesOrder::class, 'sales_order_id');
    }
}
