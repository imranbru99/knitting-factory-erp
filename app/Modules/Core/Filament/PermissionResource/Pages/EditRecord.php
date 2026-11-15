<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\PermissionResource\Pages;

use App\Modules\Core\Filament\PermissionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
