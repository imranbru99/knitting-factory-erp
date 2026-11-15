<?php

declare(strict_types=1);

namespace App\Modules\Website\Models;

use App\Modules\Support\ErpModel;
use ImranDev\UniversalSlug\Attributes\Slug;
use ImranDev\UniversalSlug\Traits\HasUniversalSlug;

#[Slug(from: 'title', to: 'slug')]
class CmsPage extends ErpModel
{
    use HasUniversalSlug;

    protected bool $scopesCompany = false;

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    protected $table = 'cms_pages';


}
