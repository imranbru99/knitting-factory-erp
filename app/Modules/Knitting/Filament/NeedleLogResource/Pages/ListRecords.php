<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\NeedleLogResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Knitting\Filament\NeedleLogResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = NeedleLogResource::class;
}
