<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\YarnTypeResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Masters\Filament\YarnTypeResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = YarnTypeResource::class;
}
