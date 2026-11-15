<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\TripResource\Pages;

use App\Modules\Delivery\Filament\TripResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = TripResource::class;
}
