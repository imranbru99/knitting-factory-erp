<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\DefectResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Masters\Filament\DefectResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = DefectResource::class;
}
