<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\PermissionResource\Pages;

use App\Modules\Core\Filament\PermissionResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = PermissionResource::class;
}
