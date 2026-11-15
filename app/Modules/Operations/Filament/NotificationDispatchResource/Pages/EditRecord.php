<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament\NotificationDispatchResource\Pages;

use App\Modules\Operations\Filament\NotificationDispatchResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = NotificationDispatchResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
