<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\DocumentSequenceResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\DocumentSequenceResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = DocumentSequenceResource::class;
}
