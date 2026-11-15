<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\GreyInspectionResource\Pages;

use App\Modules\Knitting\Filament\GreyInspectionResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = GreyInspectionResource::class;
}
