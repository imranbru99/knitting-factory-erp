<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament\PeriodLockResource\Pages;

use App\Modules\Accounts\Filament\PeriodLockResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = PeriodLockResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
