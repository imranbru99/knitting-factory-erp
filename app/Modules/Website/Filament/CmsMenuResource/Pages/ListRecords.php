<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\CmsMenuResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Website\Filament\CmsMenuResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = CmsMenuResource::class;
}
