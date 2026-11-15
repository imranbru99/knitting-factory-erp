<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\MachineStoppageResource\Pages;

use App\Modules\Knitting\Filament\MachineStoppageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = MachineStoppageResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
