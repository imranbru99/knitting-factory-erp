<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\VehicleResource\Pages;

use App\Modules\Delivery\Filament\VehicleResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = VehicleResource::class;
}
