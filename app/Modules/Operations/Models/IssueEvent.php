<?php

declare(strict_types=1);

namespace App\Modules\Operations\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class IssueEvent extends ErpModel
{
    protected $table = 'issue_events';

    public function issue(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Operations\Models\Issue::class, 'issue_id');
    }
}
