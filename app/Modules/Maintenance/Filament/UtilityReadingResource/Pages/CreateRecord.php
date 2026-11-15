<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament\UtilityReadingResource\Pages;

use App\Modules\Maintenance\Filament\UtilityReadingResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = UtilityReadingResource::class;
}
