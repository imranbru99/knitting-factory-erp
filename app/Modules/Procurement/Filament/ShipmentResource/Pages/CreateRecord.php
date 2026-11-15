<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\ShipmentResource\Pages;

use App\Modules\Procurement\Filament\ShipmentResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = ShipmentResource::class;
}
