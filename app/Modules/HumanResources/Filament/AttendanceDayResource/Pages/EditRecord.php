<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\AttendanceDayResource\Pages;

use App\Modules\HumanResources\Filament\AttendanceDayResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = AttendanceDayResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
