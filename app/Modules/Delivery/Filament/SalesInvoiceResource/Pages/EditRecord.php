<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\SalesInvoiceResource\Pages;

use App\Modules\Delivery\Filament\SalesInvoiceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = SalesInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
