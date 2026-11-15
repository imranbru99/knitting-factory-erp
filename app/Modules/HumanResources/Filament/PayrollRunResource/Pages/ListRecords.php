<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\PayrollRunResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\HumanResources\Filament\PayrollRunResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = PayrollRunResource::class;
}
