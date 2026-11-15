<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament\ShadeMatchResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Dyeing\Filament\ShadeMatchResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = ShadeMatchResource::class;
}
