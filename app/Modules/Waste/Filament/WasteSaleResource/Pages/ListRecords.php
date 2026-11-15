<?php

declare(strict_types=1);

namespace App\Modules\Waste\Filament\WasteSaleResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Waste\Filament\WasteSaleResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = WasteSaleResource::class;
}
