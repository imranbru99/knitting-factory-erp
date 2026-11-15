<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\MachineResource\Pages;

use App\Modules\Knitting\Filament\MachineResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = MachineResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
