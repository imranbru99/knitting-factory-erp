<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\TripResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Delivery\Filament\TripResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = TripResource::class;
}
