<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\CatalogProductResource\Pages;

use App\Modules\Website\Filament\CatalogProductResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = CatalogProductResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
