<?php

declare(strict_types=1);

namespace App\Modules\Quality\Filament\QcHoldResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Quality\Filament\QcHoldResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = QcHoldResource::class;
}
