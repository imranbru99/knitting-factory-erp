<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament\SparePartResource\Pages;

use App\Modules\Maintenance\Filament\SparePartResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = SparePartResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
