<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\RollResource\Pages;

use App\Modules\Knitting\Filament\RollResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = RollResource::class;
}
