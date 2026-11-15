<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\PayslipResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\HumanResources\Filament\PayslipResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = PayslipResource::class;
}
