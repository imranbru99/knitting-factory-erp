<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament\PeriodLockResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Accounts\Filament\PeriodLockResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = PeriodLockResource::class;
}
