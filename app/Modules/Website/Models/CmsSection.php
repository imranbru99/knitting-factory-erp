<?php

declare(strict_types=1);

namespace App\Modules\Website\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class CmsSection extends ErpModel
{
    protected bool $scopesCompany = false;

    protected function casts(): array
    {
        return [
            'content' => 'array',
        ];
    }

    protected $table = 'cms_sections';

    public function cms_page(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Website\Models\CmsPage::class, 'cms_page_id');
    }
}
