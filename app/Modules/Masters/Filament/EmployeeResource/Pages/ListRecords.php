<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\EmployeeResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Masters\Filament\EmployeeResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = EmployeeResource::class;
}
