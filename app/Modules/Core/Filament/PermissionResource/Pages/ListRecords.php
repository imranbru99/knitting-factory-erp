<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\PermissionResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\PermissionResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = PermissionResource::class;
}
