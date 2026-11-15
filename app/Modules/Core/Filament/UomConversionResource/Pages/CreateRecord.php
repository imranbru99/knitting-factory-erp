<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\UomConversionResource\Pages;

use App\Modules\Core\Filament\UomConversionResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = UomConversionResource::class;
}
