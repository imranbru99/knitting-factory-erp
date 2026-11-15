<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\PurchaseOrderResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Procurement\Filament\PurchaseOrderResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = PurchaseOrderResource::class;
}
