<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\FloorResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\FloorResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = FloorResource::class;
}
