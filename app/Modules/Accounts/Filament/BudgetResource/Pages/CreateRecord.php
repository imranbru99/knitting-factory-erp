<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament\BudgetResource\Pages;

use App\Modules\Accounts\Filament\BudgetResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = BudgetResource::class;
}
