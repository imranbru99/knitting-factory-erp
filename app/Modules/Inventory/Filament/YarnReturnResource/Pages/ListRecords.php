<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament\YarnReturnResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Inventory\Filament\YarnReturnResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = YarnReturnResource::class;
}
