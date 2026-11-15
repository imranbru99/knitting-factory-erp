<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\HolidayResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\HolidayResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = HolidayResource::class;
}
