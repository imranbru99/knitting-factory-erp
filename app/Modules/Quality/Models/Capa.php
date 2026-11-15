<?php

declare(strict_types=1);

namespace App\Modules\Quality\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Capa extends ErpModel
{
    public string $documentType = 'CAPA';

    protected function casts(): array
    {
        return [
            'due_on' => 'date',
        ];
    }

    protected $table = 'capas';

    public function owner(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Employee::class, 'owner_id');
    }
}
