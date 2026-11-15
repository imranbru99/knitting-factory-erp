<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\GateLogResource\Pages;

use App\Modules\Delivery\Filament\GateLogResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = GateLogResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
