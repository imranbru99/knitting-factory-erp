<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\ModuleRecordResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\ModuleRecordResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = ModuleRecordResource::class;
}
