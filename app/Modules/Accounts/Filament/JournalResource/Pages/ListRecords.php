<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament\JournalResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Accounts\Filament\JournalResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = JournalResource::class;
}
