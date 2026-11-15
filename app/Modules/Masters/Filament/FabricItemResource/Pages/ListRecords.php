<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\FabricItemResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Masters\Filament\FabricItemResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = FabricItemResource::class;
}
