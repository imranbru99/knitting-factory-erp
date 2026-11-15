<?php

declare(strict_types=1);

namespace App\Modules\Core\Models;

use App\Modules\Support\ErpModel;
class Currency extends ErpModel
{
    protected bool $scopesCompany = false;

    protected $table = 'currencies';


}
