<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\LeaveRequestResource\Pages;

use App\Modules\HumanResources\Filament\LeaveRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = LeaveRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
