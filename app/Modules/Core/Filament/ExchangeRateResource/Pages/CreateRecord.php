<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\ExchangeRateResource\Pages;

use App\Modules\Core\Filament\ExchangeRateResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = ExchangeRateResource::class;
}
