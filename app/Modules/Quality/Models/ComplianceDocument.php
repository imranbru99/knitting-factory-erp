<?php

declare(strict_types=1);

namespace App\Modules\Quality\Models;

use App\Modules\Support\ErpModel;
class ComplianceDocument extends ErpModel
{
    protected function casts(): array
    {
        return [
            'expires_on' => 'date',
        ];
    }

    protected $table = 'compliance_documents';


}
