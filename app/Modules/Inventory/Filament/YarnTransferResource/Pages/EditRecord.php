<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament\YarnTransferResource\Pages;

use App\Modules\Inventory\Filament\YarnTransferResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = YarnTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
