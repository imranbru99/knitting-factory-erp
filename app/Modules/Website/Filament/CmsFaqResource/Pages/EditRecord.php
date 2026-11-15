<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\CmsFaqResource\Pages;

use App\Modules\Website\Filament\CmsFaqResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = CmsFaqResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
