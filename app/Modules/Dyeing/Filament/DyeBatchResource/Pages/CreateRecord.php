<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament\DyeBatchResource\Pages;

use App\Modules\Dyeing\Filament\DyeBatchResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = DyeBatchResource::class;
}
