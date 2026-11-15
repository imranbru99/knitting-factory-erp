<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\CmsBannerResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Website\Filament\CmsBannerResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = CmsBannerResource::class;
}
