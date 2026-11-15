<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament\IssueResource\Pages;

use App\Modules\Operations\Filament\IssueResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = IssueResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
