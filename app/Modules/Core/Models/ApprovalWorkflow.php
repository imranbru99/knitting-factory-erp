<?php

declare(strict_types=1);

namespace App\Modules\Core\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApprovalWorkflow extends ErpModel
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected $table = 'approval_workflows';

    public function levels(): HasMany
    {
        return $this->hasMany(ApprovalLevel::class);
    }
}
