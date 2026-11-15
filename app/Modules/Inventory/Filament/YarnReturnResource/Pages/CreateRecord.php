<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament\YarnReturnResource\Pages;

use App\Modules\Inventory\Filament\YarnReturnResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = YarnReturnResource::class;
}
