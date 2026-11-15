<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\UnitResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\UnitResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = UnitResource::class;
}
