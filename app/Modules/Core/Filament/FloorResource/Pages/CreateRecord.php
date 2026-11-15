<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\FloorResource\Pages;

use App\Modules\Core\Filament\FloorResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = FloorResource::class;
}
