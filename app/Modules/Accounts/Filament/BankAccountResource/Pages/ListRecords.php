<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament\BankAccountResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Accounts\Filament\BankAccountResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = BankAccountResource::class;
}
