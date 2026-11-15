<?php

declare(strict_types=1);

namespace App\Modules\Website\Models;

use App\Modules\Support\ErpModel;
class CmsBanner extends ErpModel
{
    protected bool $scopesCompany = false;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected $table = 'cms_banners';


}
