<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament\BankLineResource\Pages;

use App\Modules\Accounts\Filament\BankLineResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = BankLineResource::class;
}
