<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament\StockLedgerResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Inventory\Filament\StockLedgerResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = StockLedgerResource::class;
}
