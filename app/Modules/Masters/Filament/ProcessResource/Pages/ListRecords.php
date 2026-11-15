<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\ProcessResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Masters\Filament\ProcessResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = ProcessResource::class;
}
