<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament\VoucherResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Accounts\Filament\VoucherResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = VoucherResource::class;
}
