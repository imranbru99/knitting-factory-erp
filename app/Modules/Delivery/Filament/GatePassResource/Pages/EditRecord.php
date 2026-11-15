<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\GatePassResource\Pages;

use App\Modules\Delivery\Filament\GatePassResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = GatePassResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
