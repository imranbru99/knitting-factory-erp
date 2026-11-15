<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament\BankLineResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Accounts\Filament\BankLineResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = BankLineResource::class;
}
