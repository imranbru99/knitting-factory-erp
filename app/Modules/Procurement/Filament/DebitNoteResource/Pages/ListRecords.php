<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\DebitNoteResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Procurement\Filament\DebitNoteResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = DebitNoteResource::class;
}
