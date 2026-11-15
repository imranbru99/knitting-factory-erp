<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\IncidentResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\HumanResources\Filament\IncidentResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = IncidentResource::class;
}
