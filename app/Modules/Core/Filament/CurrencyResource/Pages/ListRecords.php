<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\CurrencyResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\CurrencyResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = CurrencyResource::class;
}
