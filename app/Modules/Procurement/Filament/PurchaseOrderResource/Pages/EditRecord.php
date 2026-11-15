<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\PurchaseOrderResource\Pages;

use App\Modules\Procurement\Filament\PurchaseOrderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = PurchaseOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
