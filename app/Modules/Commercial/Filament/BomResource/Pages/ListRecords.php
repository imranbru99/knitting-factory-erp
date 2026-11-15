<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament\BomResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Commercial\Filament\BomResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = BomResource::class;
}
