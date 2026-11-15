<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\YarnTypeResource\Pages;

use App\Modules\Masters\Filament\YarnTypeResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = YarnTypeResource::class;
}
