<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\CmsFaqResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Website\Filament\CmsFaqResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = CmsFaqResource::class;
}
