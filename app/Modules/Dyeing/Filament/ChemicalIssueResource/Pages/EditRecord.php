<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament\ChemicalIssueResource\Pages;

use App\Modules\Dyeing\Filament\ChemicalIssueResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = ChemicalIssueResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
