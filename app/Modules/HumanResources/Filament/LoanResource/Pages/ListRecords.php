<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\LoanResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\HumanResources\Filament\LoanResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = LoanResource::class;
}
