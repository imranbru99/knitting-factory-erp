<?php

declare(strict_types=1);

namespace App\Modules\Waste\Filament\WasteEntryResource\Pages;

use App\Modules\Waste\Filament\WasteEntryResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = WasteEntryResource::class;
}
