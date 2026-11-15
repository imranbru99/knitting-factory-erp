<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\MachineBrandResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Masters\Filament\MachineBrandResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = MachineBrandResource::class;
}
