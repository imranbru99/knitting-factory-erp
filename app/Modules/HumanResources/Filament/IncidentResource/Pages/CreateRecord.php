<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\IncidentResource\Pages;

use App\Modules\HumanResources\Filament\IncidentResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = IncidentResource::class;
}
