<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament\YarnTransferResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Inventory\Filament\YarnTransferResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = YarnTransferResource::class;
}
