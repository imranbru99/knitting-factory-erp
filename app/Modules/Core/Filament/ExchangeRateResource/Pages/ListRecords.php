<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\ExchangeRateResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\ExchangeRateResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = ExchangeRateResource::class;
}
