<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\VehicleResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Delivery\Filament\VehicleResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = VehicleResource::class;
}
