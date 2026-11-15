<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\RoleResource\Pages;

use App\Modules\Core\Filament\RoleResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = RoleResource::class;
}
