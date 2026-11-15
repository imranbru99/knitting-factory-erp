<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament\QuotationResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Commercial\Filament\QuotationResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = QuotationResource::class;
}
