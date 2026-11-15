<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\CmsFaqResource\Pages;

use App\Modules\Website\Filament\CmsFaqResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = CmsFaqResource::class;
}
