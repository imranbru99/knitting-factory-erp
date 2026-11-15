<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\RfqQuoteResource\Pages;

use App\Modules\Procurement\Filament\RfqQuoteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = RfqQuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
