<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Models;

use App\Modules\Support\ErpModel;
use ImranDev\UniversalSlug\Attributes\Slug;
use ImranDev\UniversalSlug\Traits\HasUniversalSlug;

#[Slug(from: 'title', to: 'slug')]
class JobPosting extends ErpModel
{
    use HasUniversalSlug;

    protected function casts(): array
    {
        return [
            'closes_on' => 'date',
        ];
    }

    protected $table = 'job_postings';


}
