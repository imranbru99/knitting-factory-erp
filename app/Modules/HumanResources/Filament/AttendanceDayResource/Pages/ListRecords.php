<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\AttendanceDayResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\HumanResources\Filament\AttendanceDayResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = AttendanceDayResource::class;
}
