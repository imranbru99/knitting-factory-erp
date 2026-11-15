<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\LeaveRequestResource\Pages;

use App\Modules\HumanResources\Filament\LeaveRequestResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = LeaveRequestResource::class;
}
