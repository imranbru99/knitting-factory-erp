<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament\DyeBatchResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Dyeing\Filament\DyeBatchResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = DyeBatchResource::class;
}
