<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\CmsMenuResource\Pages;

use App\Modules\Website\Filament\CmsMenuResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = CmsMenuResource::class;
}
