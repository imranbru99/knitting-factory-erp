<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\PackingListResource\Pages;

use App\Modules\Delivery\Filament\PackingListResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = PackingListResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
