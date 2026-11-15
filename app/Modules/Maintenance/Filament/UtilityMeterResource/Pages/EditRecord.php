<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament\UtilityMeterResource\Pages;

use App\Modules\Maintenance\Filament\UtilityMeterResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = UtilityMeterResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
