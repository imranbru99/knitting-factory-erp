<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament\BudgetResource\Pages;

use App\Modules\Accounts\Filament\BudgetResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = BudgetResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
