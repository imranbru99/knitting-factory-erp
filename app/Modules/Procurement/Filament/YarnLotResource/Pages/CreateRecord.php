<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\YarnLotResource\Pages;

use App\Modules\Procurement\Filament\YarnLotResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = YarnLotResource::class;
}
