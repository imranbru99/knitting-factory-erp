<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\LeaveRequestResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\HumanResources\Filament\LeaveRequestResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = LeaveRequestResource::class;
}
