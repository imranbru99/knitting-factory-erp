<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\PayrollRunResource\Pages;

use App\Modules\HumanResources\Filament\PayrollRunResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = PayrollRunResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
