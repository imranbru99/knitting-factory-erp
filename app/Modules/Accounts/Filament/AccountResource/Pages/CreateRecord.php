<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament\AccountResource\Pages;

use App\Modules\Accounts\Filament\AccountResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = AccountResource::class;
}
