<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\PartyResource\Pages;

use App\Modules\Masters\Filament\PartyResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = PartyResource::class;
}
