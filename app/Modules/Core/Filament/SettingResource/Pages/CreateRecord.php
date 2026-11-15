<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\SettingResource\Pages;

use App\Modules\Core\Filament\SettingResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = SettingResource::class;
}
