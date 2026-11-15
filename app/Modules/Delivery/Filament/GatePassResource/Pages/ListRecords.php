<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\GatePassResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Delivery\Filament\GatePassResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = GatePassResource::class;
}
