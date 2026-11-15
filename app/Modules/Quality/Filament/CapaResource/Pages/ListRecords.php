<?php

declare(strict_types=1);

namespace App\Modules\Quality\Filament\CapaResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Quality\Filament\CapaResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = CapaResource::class;
}
