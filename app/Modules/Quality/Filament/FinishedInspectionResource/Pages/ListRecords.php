<?php

declare(strict_types=1);

namespace App\Modules\Quality\Filament\FinishedInspectionResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Quality\Filament\FinishedInspectionResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = FinishedInspectionResource::class;
}
