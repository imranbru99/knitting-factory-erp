<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament\DyeMachineResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Dyeing\Filament\DyeMachineResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = DyeMachineResource::class;
}
