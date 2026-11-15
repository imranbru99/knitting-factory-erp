<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\HolidayResource\Pages;

use App\Modules\Core\Filament\HolidayResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = HolidayResource::class;
}
