<?php

declare(strict_types=1);

namespace App\Modules\Website\Models;

use App\Modules\Support\ErpModel;
class CmsMedia extends ErpModel
{
    protected bool $scopesCompany = false;

    protected $table = 'cms_media';


}
