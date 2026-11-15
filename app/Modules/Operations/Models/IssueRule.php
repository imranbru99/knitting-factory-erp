<?php

declare(strict_types=1);

namespace App\Modules\Operations\Models;

use App\Modules\Support\ErpModel;
class IssueRule extends ErpModel
{
    protected function casts(): array
    {
        return [
            'enabled' => 'boolean',
            'thresholds' => 'array',
        ];
    }

    protected $table = 'issue_rules';


}
