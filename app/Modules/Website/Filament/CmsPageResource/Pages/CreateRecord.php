<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\CmsPageResource\Pages;

use App\Modules\Website\Filament\CmsPageResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = CmsPageResource::class;
}
