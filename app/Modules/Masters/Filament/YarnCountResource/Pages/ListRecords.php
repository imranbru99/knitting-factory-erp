<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\YarnCountResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Masters\Filament\YarnCountResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = YarnCountResource::class;
}
