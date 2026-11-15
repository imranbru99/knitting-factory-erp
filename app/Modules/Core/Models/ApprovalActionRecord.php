<?php

declare(strict_types=1);

namespace App\Modules\Core\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ApprovalActionRecord extends ErpModel
{
    protected function casts(): array
    {
        return [
            'acted_at' => 'datetime',
        ];
    }

    protected $table = 'approval_actions';

    public function approval_request(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\ApprovalRequest::class, 'approval_request_id');
    }
}
