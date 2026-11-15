<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\SalesInvoiceResource\Pages;

use App\Modules\Delivery\Filament\SalesInvoiceResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = SalesInvoiceResource::class;
}
