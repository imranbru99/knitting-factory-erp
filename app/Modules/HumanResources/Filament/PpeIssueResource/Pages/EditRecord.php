<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\PpeIssueResource\Pages;

use App\Modules\HumanResources\Filament\PpeIssueResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = PpeIssueResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
