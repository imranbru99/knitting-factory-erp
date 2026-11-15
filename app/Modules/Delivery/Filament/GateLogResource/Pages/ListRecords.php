<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\GateLogResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Delivery\Filament\GateLogResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = GateLogResource::class;
}
