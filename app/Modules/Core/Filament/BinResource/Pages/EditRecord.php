<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\BinResource\Pages;

use App\Modules\Core\Filament\BinResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = BinResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
