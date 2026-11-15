<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\NeedleLogResource\Pages;

use App\Modules\Knitting\Filament\NeedleLogResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = NeedleLogResource::class;
}
