<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\CreditNoteResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Delivery\Filament\CreditNoteResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = CreditNoteResource::class;
}
