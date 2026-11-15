<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\CmsMediaResource\Pages;

use App\Modules\Website\Filament\CmsMediaResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = CmsMediaResource::class;
}
