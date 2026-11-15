<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\MachineStoppageResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Knitting\Filament\MachineStoppageResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = MachineStoppageResource::class;
}
