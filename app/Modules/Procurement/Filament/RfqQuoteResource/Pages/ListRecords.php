<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\RfqQuoteResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Procurement\Filament\RfqQuoteResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = RfqQuoteResource::class;
}
