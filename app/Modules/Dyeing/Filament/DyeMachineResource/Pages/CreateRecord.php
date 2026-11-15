<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament\DyeMachineResource\Pages;

use App\Modules\Dyeing\Filament\DyeMachineResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = DyeMachineResource::class;
}
