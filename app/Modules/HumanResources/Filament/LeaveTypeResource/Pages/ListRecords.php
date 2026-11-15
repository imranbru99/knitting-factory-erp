<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\LeaveTypeResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\HumanResources\Filament\LeaveTypeResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = LeaveTypeResource::class;
}
