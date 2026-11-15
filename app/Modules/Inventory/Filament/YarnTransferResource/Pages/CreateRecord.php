<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament\YarnTransferResource\Pages;

use App\Modules\Inventory\Filament\YarnTransferResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = YarnTransferResource::class;
}
