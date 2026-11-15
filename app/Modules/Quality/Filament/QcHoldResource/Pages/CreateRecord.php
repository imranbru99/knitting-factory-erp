<?php

declare(strict_types=1);

namespace App\Modules\Quality\Filament\QcHoldResource\Pages;

use App\Modules\Quality\Filament\QcHoldResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = QcHoldResource::class;
}
