<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\LoanResource\Pages;

use App\Modules\HumanResources\Filament\LoanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = LoanResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
