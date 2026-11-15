<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\DepartmentResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Masters\Filament\DepartmentResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = DepartmentResource::class;
}
