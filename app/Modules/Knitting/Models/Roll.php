<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Roll extends ErpModel
{
    public string $documentType = 'ROLL';

    protected function casts(): array
    {
        return [
            'gross_kg' => 'decimal:4',
            'net_kg' => 'decimal:4',
            'gsm' => 'decimal:4',
            'dia' => 'decimal:4',
            'yards' => 'decimal:4',
            'yarn_lots' => 'array',
            'produced_at' => 'datetime',
        ];
    }

    protected $table = 'rolls';

    public function knitting_program(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Knitting\Models\KnittingProgram::class, 'knitting_program_id');
    }
    public function machine(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Knitting\Models\Machine::class, 'machine_id');
    }
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Warehouse::class, 'warehouse_id');
    }
    public function sales_order(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Commercial\Models\SalesOrder::class, 'sales_order_id');
    }
}
