<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\PartyResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Masters\Filament\PartyResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = PartyResource::class;
}
