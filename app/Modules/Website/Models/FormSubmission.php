<?php

declare(strict_types=1);

namespace App\Modules\Website\Models;

use App\Modules\Support\ErpModel;
class FormSubmission extends ErpModel
{
    protected bool $scopesCompany = false;

    protected function casts(): array
    {
        return [
            'payload' => 'array',
        ];
    }

    protected $table = 'form_submissions';


}
