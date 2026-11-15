<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament\BudgetResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Accounts\Filament\BudgetResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = BudgetResource::class;
}
