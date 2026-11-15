<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\UomConversionResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\UomConversionResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = UomConversionResource::class;
}
