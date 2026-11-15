<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\NeedleLogResource\Pages;

use App\Modules\Knitting\Filament\NeedleLogResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = NeedleLogResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
