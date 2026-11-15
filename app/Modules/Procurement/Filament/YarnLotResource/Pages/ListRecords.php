<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\YarnLotResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Procurement\Filament\YarnLotResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = YarnLotResource::class;
}
