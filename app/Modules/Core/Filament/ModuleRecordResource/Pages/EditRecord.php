<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\ModuleRecordResource\Pages;

use App\Modules\Core\Filament\ModuleRecordResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = ModuleRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
