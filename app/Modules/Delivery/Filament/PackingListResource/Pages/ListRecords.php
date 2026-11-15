<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\PackingListResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Delivery\Filament\PackingListResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = PackingListResource::class;
}
