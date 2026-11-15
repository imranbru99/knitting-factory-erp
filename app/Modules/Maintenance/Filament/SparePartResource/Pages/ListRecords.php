<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament\SparePartResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Maintenance\Filament\SparePartResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = SparePartResource::class;
}
