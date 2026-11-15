<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\CmsPostResource\Pages;

use App\Modules\Website\Filament\CmsPostResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = CmsPostResource::class;
}
