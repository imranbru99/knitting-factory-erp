<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\AttendanceDayResource\Pages;

use App\Modules\HumanResources\Filament\AttendanceDayResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = AttendanceDayResource::class;
}
