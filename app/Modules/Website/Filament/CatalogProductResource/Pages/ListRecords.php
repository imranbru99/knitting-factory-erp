<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\CatalogProductResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Website\Filament\CatalogProductResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = CatalogProductResource::class;
}
