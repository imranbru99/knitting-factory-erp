<?php

declare(strict_types=1);

namespace App\Modules\Quality\Filament\CapaResource\Pages;

use App\Modules\Quality\Filament\CapaResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = CapaResource::class;
}
