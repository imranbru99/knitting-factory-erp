<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament\UtilityMeterResource\Pages;

use App\Modules\Maintenance\Filament\UtilityMeterResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = UtilityMeterResource::class;
}
