<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament\StockCountResource\Pages;

use App\Modules\Inventory\Filament\StockCountResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = StockCountResource::class;
}
