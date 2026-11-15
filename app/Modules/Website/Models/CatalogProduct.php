<?php

declare(strict_types=1);

namespace App\Modules\Website\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use ImranDev\UniversalSlug\Attributes\Slug;
use ImranDev\UniversalSlug\Traits\HasUniversalSlug;

#[Slug(from: 'title', to: 'slug')]
class CatalogProduct extends ErpModel
{
    use HasUniversalSlug;

    protected bool $scopesCompany = false;

    protected function casts(): array
    {
        return [
            'published' => 'boolean',
        ];
    }

    protected $table = 'catalog_products';

    public function fabric_item(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\FabricItem::class, 'fabric_item_id');
    }
}
