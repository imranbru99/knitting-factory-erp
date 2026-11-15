<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament\StockCountResource\Pages;

use App\Modules\Inventory\Filament\StockCountResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = StockCountResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
