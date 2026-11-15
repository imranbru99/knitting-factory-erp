<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\SupplierBillResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Procurement\Filament\SupplierBillResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = SupplierBillResource::class;
}
