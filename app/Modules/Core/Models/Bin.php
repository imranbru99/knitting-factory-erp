<?php

declare(strict_types=1);

namespace App\Modules\Core\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Bin extends ErpModel
{
    protected $table = 'bins';

    public function rack(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Rack::class, 'rack_id');
    }
}
