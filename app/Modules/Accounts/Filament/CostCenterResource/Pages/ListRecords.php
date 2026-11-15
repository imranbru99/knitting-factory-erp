<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament\CostCenterResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Accounts\Filament\CostCenterResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = CostCenterResource::class;
}
