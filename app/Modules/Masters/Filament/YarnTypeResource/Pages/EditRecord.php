<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\YarnTypeResource\Pages;

use App\Modules\Masters\Filament\YarnTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = YarnTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
