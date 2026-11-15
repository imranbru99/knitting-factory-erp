<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\ShiftResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\ShiftResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = ShiftResource::class;
}
