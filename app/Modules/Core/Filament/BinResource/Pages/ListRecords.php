<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\BinResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\BinResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = BinResource::class;
}
