<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Requisition extends ErpModel
{
    public string $documentType = 'REQ';

    protected function casts(): array
    {
        return [
            'needed_on' => 'date',
        ];
    }

    protected $table = 'requisitions';

    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Procurement\Models\RequisitionLine::class);
    }
}
