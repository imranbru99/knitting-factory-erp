<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\LeaveTypeResource\Pages;

use App\Modules\HumanResources\Filament\LeaveTypeResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = LeaveTypeResource::class;
}
