<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\CmsBannerResource\Pages;

use App\Modules\Website\Filament\CmsBannerResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = CmsBannerResource::class;
}
