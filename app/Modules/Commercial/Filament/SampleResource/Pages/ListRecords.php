<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament\SampleResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Commercial\Filament\SampleResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = SampleResource::class;
}
