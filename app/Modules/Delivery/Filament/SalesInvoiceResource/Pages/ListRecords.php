<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\SalesInvoiceResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Delivery\Filament\SalesInvoiceResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = SalesInvoiceResource::class;
}
