<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament\TaskItemResource\Pages;

use App\Modules\Operations\Filament\TaskItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = TaskItemResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
