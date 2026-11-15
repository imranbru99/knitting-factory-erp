<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\CmsPageResource\Pages;

use App\Modules\Website\Filament\CmsPageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = CmsPageResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
