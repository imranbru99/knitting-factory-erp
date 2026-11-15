<?php

declare(strict_types=1);

namespace App\Modules\Quality\Filament\ComplianceDocumentResource\Pages;

use App\Modules\Quality\Filament\ComplianceDocumentResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = ComplianceDocumentResource::class;
}
