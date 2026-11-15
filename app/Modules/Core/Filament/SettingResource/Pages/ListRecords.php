<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\SettingResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\SettingResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = SettingResource::class;
}
