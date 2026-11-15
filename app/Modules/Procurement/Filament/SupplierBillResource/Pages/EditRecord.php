<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\SupplierBillResource\Pages;

use App\Modules\Procurement\Filament\SupplierBillResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = SupplierBillResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
