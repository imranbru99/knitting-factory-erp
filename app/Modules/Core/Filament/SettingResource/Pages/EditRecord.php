<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\SettingResource\Pages;

use App\Modules\Core\Filament\SettingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
