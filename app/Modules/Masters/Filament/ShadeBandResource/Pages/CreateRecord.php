<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\ShadeBandResource\Pages;

use App\Modules\Masters\Filament\ShadeBandResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = ShadeBandResource::class;
}
