<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\CmsMenuItemResource\Pages;

use App\Modules\Website\Filament\CmsMenuItemResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = CmsMenuItemResource::class;
}
