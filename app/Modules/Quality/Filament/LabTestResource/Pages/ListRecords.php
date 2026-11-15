<?php

declare(strict_types=1);

namespace App\Modules\Quality\Filament\LabTestResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Quality\Filament\LabTestResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = LabTestResource::class;
}
