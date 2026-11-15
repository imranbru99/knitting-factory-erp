<?php

declare(strict_types=1);

namespace App\Modules\Quality\Filament\QcHoldResource\Pages;

use App\Modules\Quality\Filament\QcHoldResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = QcHoldResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
