<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\CompanyResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\CompanyResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = CompanyResource::class;
}
