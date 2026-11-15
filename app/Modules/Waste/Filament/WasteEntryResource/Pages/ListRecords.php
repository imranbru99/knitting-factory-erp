<?php

declare(strict_types=1);

namespace App\Modules\Waste\Filament\WasteEntryResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Waste\Filament\WasteEntryResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = WasteEntryResource::class;
}
