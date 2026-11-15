<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\ProductionEntryResource\Pages;

use App\Modules\Knitting\Filament\ProductionEntryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = ProductionEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
