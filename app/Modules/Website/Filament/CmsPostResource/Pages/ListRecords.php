<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\CmsPostResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Website\Filament\CmsPostResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = CmsPostResource::class;
}
