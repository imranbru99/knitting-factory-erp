<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\MachineResource\Pages;

use App\Modules\Knitting\Filament\MachineResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = MachineResource::class;
}
