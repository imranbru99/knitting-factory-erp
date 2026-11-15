<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament\LabDipResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Dyeing\Filament\LabDipResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = LabDipResource::class;
}
