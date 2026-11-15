<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament\LabDipResource\Pages;

use App\Modules\Dyeing\Filament\LabDipResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = LabDipResource::class;
}
