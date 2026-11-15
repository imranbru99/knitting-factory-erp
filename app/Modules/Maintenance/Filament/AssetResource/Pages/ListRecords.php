<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament\AssetResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Maintenance\Filament\AssetResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = AssetResource::class;
}
