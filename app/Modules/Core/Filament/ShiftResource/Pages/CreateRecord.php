<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\ShiftResource\Pages;

use App\Modules\Core\Filament\ShiftResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = ShiftResource::class;
}
