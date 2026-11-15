<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament\NotificationDispatchResource\Pages;

use App\Modules\Operations\Filament\NotificationDispatchResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = NotificationDispatchResource::class;
}
