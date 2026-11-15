<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament\YarnReturnResource\Pages;

use App\Modules\Inventory\Filament\YarnReturnResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = YarnReturnResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
