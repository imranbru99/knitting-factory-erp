<?php

declare(strict_types=1);

namespace App\Modules\Quality\Filament\LabTestResource\Pages;

use App\Modules\Quality\Filament\LabTestResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = LabTestResource::class;
}
