<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\UomResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\UomResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = UomResource::class;
}
