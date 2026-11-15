<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\DefectResource\Pages;

use App\Modules\Masters\Filament\DefectResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = DefectResource::class;
}
