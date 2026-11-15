<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class JobApplication extends ErpModel
{
    protected $table = 'job_applications';

    public function job_posting(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\HumanResources\Models\JobPosting::class, 'job_posting_id');
    }
}
