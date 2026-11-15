<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\ImportLcResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Procurement\Filament\ImportLcResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = ImportLcResource::class;
}
