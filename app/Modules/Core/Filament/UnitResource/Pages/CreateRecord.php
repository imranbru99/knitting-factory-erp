<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\UnitResource\Pages;

use App\Modules\Core\Filament\UnitResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = UnitResource::class;
}
