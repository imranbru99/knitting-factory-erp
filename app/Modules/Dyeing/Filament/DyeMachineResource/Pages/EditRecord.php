<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament\DyeMachineResource\Pages;

use App\Modules\Dyeing\Filament\DyeMachineResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = DyeMachineResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
