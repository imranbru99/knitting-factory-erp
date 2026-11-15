<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\MachineStoppageResource\Pages;

use App\Modules\Knitting\Filament\MachineStoppageResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = MachineStoppageResource::class;
}
