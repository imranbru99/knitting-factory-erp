<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament\WorkOrderResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Maintenance\Filament\WorkOrderResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = WorkOrderResource::class;
}
