<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\GatePassResource\Pages;

use App\Modules\Delivery\Filament\GatePassResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = GatePassResource::class;
}
