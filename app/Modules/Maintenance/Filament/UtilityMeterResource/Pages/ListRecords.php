<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament\UtilityMeterResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Maintenance\Filament\UtilityMeterResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = UtilityMeterResource::class;
}
