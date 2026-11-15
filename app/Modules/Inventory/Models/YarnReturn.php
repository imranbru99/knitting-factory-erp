<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class YarnReturn extends ErpModel
{
    public string $documentType = 'YRT';

    protected function casts(): array
    {
        return [
            'qty' => 'decimal:4',
        ];
    }

    protected $table = 'yarn_returns';

    public function yarn_issue(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Inventory\Models\YarnIssue::class, 'yarn_issue_id');
    }
    public function yarn_lot(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Procurement\Models\YarnLot::class, 'yarn_lot_id');
    }
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Warehouse::class, 'warehouse_id');
    }
}
