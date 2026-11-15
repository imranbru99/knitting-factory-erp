<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\GoodsReceiptResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Procurement\Filament\GoodsReceiptResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = GoodsReceiptResource::class;
}
