<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament\PriceListResource\Pages;

use App\Modules\Commercial\Filament\PriceListResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = PriceListResource::class;
}
