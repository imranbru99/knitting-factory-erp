<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\DisciplinaryActionResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\HumanResources\Filament\DisciplinaryActionResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = DisciplinaryActionResource::class;
}
