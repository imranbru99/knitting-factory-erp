<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\SalaryStructureResource\Pages;

use App\Modules\HumanResources\Filament\SalaryStructureResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = SalaryStructureResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
