<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\FabricConstructionResource\Pages;

use App\Modules\Masters\Filament\FabricConstructionResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = FabricConstructionResource::class;
}
