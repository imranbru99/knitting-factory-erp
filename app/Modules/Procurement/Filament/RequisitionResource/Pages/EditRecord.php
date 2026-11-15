<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\RequisitionResource\Pages;

use App\Modules\Procurement\Filament\RequisitionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = RequisitionResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
