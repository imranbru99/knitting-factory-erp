<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\YarnItemResource\Pages;

use App\Modules\Masters\Filament\YarnItemResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = YarnItemResource::class;
}
