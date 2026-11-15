<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament\ShadeMatchResource\Pages;

use App\Modules\Dyeing\Filament\ShadeMatchResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = ShadeMatchResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
