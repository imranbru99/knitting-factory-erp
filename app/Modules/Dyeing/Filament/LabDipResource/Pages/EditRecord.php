<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament\LabDipResource\Pages;

use App\Modules\Dyeing\Filament\LabDipResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = LabDipResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
