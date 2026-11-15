<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament\WorkOrderResource\Pages;

use App\Modules\Maintenance\Filament\WorkOrderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = WorkOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
