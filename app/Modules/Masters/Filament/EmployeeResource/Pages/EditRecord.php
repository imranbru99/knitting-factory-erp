<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\EmployeeResource\Pages;

use App\Modules\Masters\Filament\EmployeeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
