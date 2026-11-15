<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\MachineResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Knitting\Filament\MachineResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = MachineResource::class;
}
