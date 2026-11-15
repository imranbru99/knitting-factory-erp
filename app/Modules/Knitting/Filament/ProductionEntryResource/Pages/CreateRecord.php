<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\ProductionEntryResource\Pages;

use App\Modules\Knitting\Filament\ProductionEntryResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = ProductionEntryResource::class;
}
