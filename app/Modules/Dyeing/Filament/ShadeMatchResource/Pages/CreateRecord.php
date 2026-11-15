<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament\ShadeMatchResource\Pages;

use App\Modules\Dyeing\Filament\ShadeMatchResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = ShadeMatchResource::class;
}
