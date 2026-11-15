<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\DebitNoteResource\Pages;

use App\Modules\Procurement\Filament\DebitNoteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = DebitNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
