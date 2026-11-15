<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\IncidentResource\Pages;

use App\Modules\HumanResources\Filament\IncidentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = IncidentResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
