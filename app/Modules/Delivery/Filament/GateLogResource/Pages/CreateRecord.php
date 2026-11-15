<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\GateLogResource\Pages;

use App\Modules\Delivery\Filament\GateLogResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = GateLogResource::class;
}
