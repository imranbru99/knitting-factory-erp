<?php

declare(strict_types=1);

namespace App\Modules\Quality\Filament\FinishedInspectionResource\Pages;

use App\Modules\Quality\Filament\FinishedInspectionResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = FinishedInspectionResource::class;
}
