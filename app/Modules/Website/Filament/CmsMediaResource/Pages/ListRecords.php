<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\CmsMediaResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Website\Filament\CmsMediaResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = CmsMediaResource::class;
}
