<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\SubcontractJobResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Knitting\Filament\SubcontractJobResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = SubcontractJobResource::class;
}
