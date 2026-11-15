<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\CatalogProductResource\Pages;

use App\Modules\Website\Filament\CatalogProductResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = CatalogProductResource::class;
}
