<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament\SparePartResource\Pages;

use App\Modules\Maintenance\Filament\SparePartResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = SparePartResource::class;
}
