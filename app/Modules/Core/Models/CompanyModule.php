<?php

declare(strict_types=1);

namespace App\Modules\Core\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class CompanyModule extends ErpModel
{
    protected function casts(): array
    {
        return [
            'enabled' => 'boolean',
        ];
    }

    protected $table = 'company_modules';

    public function company(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Core\Models\Company::class, 'company_id');
    }
}
