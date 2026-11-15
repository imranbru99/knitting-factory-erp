<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\FabricConstructionResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Masters\Filament\FabricConstructionResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = FabricConstructionResource::class;
}
