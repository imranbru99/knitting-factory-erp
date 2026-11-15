<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class YarnIssue extends ErpModel
{
    public string $documentType = 'YIS';

    protected function casts(): array
    {
        return [
            'issued_on' => 'date',
        ];
    }

    protected $table = 'yarn_issues';

    public function knitting_program(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Knitting\Models\KnittingProgram::class, 'knitting_program_id');
    }
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Warehouse::class, 'warehouse_id');
    }
    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Inventory\Models\YarnIssueLine::class);
    }
}
