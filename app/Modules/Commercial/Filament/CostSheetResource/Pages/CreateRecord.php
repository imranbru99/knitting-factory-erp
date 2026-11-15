<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament\CostSheetResource\Pages;

use App\Modules\Commercial\Filament\CostSheetResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = CostSheetResource::class;
}
