<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\ImportLcResource\Pages;

use App\Modules\Procurement\Filament\ImportLcResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = ImportLcResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
