<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament\AssetResource\Pages;

use App\Modules\Maintenance\Filament\AssetResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = AssetResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
