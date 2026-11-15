<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\ProductionEntryResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Knitting\Filament\ProductionEntryResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = ProductionEntryResource::class;
}
