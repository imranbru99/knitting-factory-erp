<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament\YarnIssueResource\Pages;

use App\Modules\Inventory\Filament\YarnIssueResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = YarnIssueResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
