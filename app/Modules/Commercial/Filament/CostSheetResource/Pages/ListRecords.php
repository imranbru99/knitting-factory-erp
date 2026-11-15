<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament\CostSheetResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Commercial\Filament\CostSheetResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = CostSheetResource::class;
}
