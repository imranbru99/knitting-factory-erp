<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament\FinishingLogResource\Pages;

use App\Modules\Dyeing\Filament\FinishingLogResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = FinishingLogResource::class;
}
