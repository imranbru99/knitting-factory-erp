<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament\SalesOrderResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Commercial\Filament\SalesOrderResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = SalesOrderResource::class;
}
