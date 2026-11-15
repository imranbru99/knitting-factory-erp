<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\RackResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\RackResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = RackResource::class;
}
