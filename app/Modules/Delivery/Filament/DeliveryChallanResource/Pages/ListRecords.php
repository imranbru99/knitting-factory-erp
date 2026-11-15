<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\DeliveryChallanResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Delivery\Filament\DeliveryChallanResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = DeliveryChallanResource::class;
}
