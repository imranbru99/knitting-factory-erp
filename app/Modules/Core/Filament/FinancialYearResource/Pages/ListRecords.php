<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\FinancialYearResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\FinancialYearResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = FinancialYearResource::class;
}
