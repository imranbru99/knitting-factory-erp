<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament\BankAccountResource\Pages;

use App\Modules\Accounts\Filament\BankAccountResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = BankAccountResource::class;
}
