<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\ProcessResource\Pages;

use App\Modules\Masters\Filament\ProcessResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = ProcessResource::class;
}
