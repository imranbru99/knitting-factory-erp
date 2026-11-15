<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\CompanyModuleResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\CompanyModuleResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = CompanyModuleResource::class;
}
