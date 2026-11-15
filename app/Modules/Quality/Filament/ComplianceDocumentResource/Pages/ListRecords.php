<?php

declare(strict_types=1);

namespace App\Modules\Quality\Filament\ComplianceDocumentResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Quality\Filament\ComplianceDocumentResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = ComplianceDocumentResource::class;
}
