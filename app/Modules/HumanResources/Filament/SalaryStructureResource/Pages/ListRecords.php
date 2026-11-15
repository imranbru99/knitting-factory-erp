<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\SalaryStructureResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\HumanResources\Filament\SalaryStructureResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = SalaryStructureResource::class;
}
