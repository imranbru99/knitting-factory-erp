<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament\YarnIssueResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Inventory\Filament\YarnIssueResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = YarnIssueResource::class;
}
