<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament\OrderAmendmentResource\Pages;

use App\Modules\Commercial\Filament\OrderAmendmentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = OrderAmendmentResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
