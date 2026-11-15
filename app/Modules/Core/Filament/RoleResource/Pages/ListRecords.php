<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\RoleResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\RoleResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = RoleResource::class;
}
