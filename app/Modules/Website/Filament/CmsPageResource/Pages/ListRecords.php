<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\CmsPageResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Website\Filament\CmsPageResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = CmsPageResource::class;
}
