<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\SubcontractJobResource\Pages;

use App\Modules\Knitting\Filament\SubcontractJobResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = SubcontractJobResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
