<?php

declare(strict_types=1);

namespace App\Modules\Waste\Filament\WasteEntryResource\Pages;

use App\Modules\Waste\Filament\WasteEntryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = WasteEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
