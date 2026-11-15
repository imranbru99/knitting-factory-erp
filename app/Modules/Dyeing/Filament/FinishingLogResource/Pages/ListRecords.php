<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament\FinishingLogResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Dyeing\Filament\FinishingLogResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = FinishingLogResource::class;
}
