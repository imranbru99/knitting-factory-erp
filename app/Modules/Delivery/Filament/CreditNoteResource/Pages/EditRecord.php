<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\CreditNoteResource\Pages;

use App\Modules\Delivery\Filament\CreditNoteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = CreditNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
