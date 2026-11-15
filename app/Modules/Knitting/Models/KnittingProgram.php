<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class KnittingProgram extends ErpModel
{
    public string $documentType = 'KP';

    protected function casts(): array
    {
        return [
            'target_kg' => 'decimal:4',
            'target_gsm' => 'decimal:4',
            'stitch_length' => 'decimal:4',
            'dia' => 'decimal:4',
            'planned_start' => 'datetime',
            'planned_end' => 'datetime',
        ];
    }

    protected $table = 'knitting_programs';

    public function sales_order(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Commercial\Models\SalesOrder::class, 'sales_order_id');
    }
    public function sales_order_line(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Commercial\Models\SalesOrderLine::class, 'sales_order_line_id');
    }
    public function machine(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Knitting\Models\Machine::class, 'machine_id');
    }
    public function fabric_item(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\FabricItem::class, 'fabric_item_id');
    }
    public function color(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Color::class, 'color_id');
    }
    public function operator(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Employee::class, 'operator_id');
    }
    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Knitting\Models\KnittingProgramYarn::class);
    }
}
