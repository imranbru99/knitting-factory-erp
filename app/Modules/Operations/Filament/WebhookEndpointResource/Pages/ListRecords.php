<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament\WebhookEndpointResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Operations\Filament\WebhookEndpointResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = WebhookEndpointResource::class;
}
