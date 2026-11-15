<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\WarehouseResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\WarehouseResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = WarehouseResource::class;
}
