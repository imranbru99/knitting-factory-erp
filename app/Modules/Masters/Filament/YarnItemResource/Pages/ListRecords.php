<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\YarnItemResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Masters\Filament\YarnItemResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = YarnItemResource::class;
}
