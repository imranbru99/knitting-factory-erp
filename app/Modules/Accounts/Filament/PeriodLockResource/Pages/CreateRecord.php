<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament\PeriodLockResource\Pages;

use App\Modules\Accounts\Filament\PeriodLockResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = PeriodLockResource::class;
}
