<?php

declare(strict_types=1);

namespace App\Modules\Website\Models;

use App\Modules\Support\ErpModel;
class CmsFaq extends ErpModel
{
    protected bool $scopesCompany = false;

    protected $table = 'cms_faqs';


}
