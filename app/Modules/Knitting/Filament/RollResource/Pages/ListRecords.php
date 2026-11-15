<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\RollResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Knitting\Filament\RollResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = RollResource::class;
}
