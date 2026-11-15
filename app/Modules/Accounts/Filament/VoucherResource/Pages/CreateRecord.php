<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament\VoucherResource\Pages;

use App\Modules\Accounts\Filament\VoucherResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = VoucherResource::class;
}
