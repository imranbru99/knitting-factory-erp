<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\TripResource\Pages;

use App\Modules\Delivery\Filament\TripResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = TripResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
