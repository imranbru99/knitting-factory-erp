<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament\WebhookEndpointResource\Pages;

use App\Modules\Operations\Filament\WebhookEndpointResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = WebhookEndpointResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
