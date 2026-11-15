<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament\UtilityReadingResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Maintenance\Filament\UtilityReadingResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = UtilityReadingResource::class;
}
