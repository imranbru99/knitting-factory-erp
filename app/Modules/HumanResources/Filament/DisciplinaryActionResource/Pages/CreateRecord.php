<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\DisciplinaryActionResource\Pages;

use App\Modules\HumanResources\Filament\DisciplinaryActionResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = DisciplinaryActionResource::class;
}
