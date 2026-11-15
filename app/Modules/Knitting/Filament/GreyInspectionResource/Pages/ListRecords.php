<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\GreyInspectionResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Knitting\Filament\GreyInspectionResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = GreyInspectionResource::class;
}
