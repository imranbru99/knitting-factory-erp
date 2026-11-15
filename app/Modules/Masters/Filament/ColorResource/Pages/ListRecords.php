<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\ColorResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Masters\Filament\ColorResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = ColorResource::class;
}
