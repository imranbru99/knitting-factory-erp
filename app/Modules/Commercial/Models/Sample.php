<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Sample extends ErpModel
{
    protected function casts(): array
    {
        return [
            'approved_on' => 'date',
        ];
    }

    protected $table = 'samples';

    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Commercial\Models\Inquiry::class, 'inquiry_id');
    }
}
