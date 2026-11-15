<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament\MaintenanceScheduleResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Maintenance\Filament\MaintenanceScheduleResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = MaintenanceScheduleResource::class;
}
