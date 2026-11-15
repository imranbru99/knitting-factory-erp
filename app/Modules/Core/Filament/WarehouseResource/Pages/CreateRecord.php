<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\WarehouseResource\Pages;

use App\Modules\Core\Filament\WarehouseResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = WarehouseResource::class;
}
