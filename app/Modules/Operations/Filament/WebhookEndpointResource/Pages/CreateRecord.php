<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament\WebhookEndpointResource\Pages;

use App\Modules\Operations\Filament\WebhookEndpointResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = WebhookEndpointResource::class;
}
