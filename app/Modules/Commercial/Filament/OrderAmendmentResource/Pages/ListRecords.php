<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament\OrderAmendmentResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Commercial\Filament\OrderAmendmentResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = OrderAmendmentResource::class;
}
