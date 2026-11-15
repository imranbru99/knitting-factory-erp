<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\UomResource\Pages;

use App\Modules\Core\Filament\UomResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = UomResource::class;
}
