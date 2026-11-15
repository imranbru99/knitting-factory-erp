<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\KnittingProgramResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Knitting\Filament\KnittingProgramResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = KnittingProgramResource::class;
}
