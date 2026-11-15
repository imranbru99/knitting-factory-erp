<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament\AssetResource\Pages;

use App\Modules\Maintenance\Filament\AssetResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = AssetResource::class;
}
