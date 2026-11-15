<?php

declare(strict_types=1);

namespace App\Modules\Website\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class CmsMenuItem extends ErpModel
{
    protected bool $scopesCompany = false;

    protected $table = 'cms_menu_items';

    public function cms_menu(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Website\Models\CmsMenu::class, 'cms_menu_id');
    }
}
