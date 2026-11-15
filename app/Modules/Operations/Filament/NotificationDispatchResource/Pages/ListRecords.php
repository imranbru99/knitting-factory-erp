<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament\NotificationDispatchResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Operations\Filament\NotificationDispatchResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = NotificationDispatchResource::class;
}
