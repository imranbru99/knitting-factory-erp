<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\MachineBrandResource\Pages;

use App\Modules\Masters\Filament\MachineBrandResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = MachineBrandResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
