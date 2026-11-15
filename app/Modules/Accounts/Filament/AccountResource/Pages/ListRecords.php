<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament\AccountResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Accounts\Filament\AccountResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = AccountResource::class;
}
