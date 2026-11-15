<?php

declare(strict_types=1);

namespace App\Modules\Core\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ApprovalRequest extends ErpModel
{
    protected $table = 'approval_requests';

    public function approval_workflow(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\ApprovalWorkflow::class, 'approval_workflow_id');
    }
}
