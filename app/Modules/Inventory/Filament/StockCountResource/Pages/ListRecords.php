<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament\StockCountResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Inventory\Filament\StockCountResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = StockCountResource::class;
}
