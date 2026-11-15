<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament\AccountResource\Pages;

use App\Modules\Accounts\Filament\AccountResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = AccountResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
