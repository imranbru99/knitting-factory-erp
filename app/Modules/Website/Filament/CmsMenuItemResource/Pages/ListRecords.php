<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\CmsMenuItemResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Website\Filament\CmsMenuItemResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = CmsMenuItemResource::class;
}
