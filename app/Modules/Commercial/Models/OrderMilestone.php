<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class OrderMilestone extends ErpModel
{
    protected function casts(): array
    {
        return [
            'planned_on' => 'date',
            'actual_on' => 'date',
        ];
    }

    protected $table = 'order_milestones';

    public function sales_order(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Commercial\Models\SalesOrder::class, 'sales_order_id');
    }
}
