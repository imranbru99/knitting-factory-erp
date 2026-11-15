<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\ShadeBandResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Masters\Filament\ShadeBandResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = ShadeBandResource::class;
}
