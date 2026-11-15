<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\ProcessResource\Pages;

use App\Modules\Masters\Filament\ProcessResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = ProcessResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
