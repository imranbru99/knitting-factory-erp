<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\DepartmentResource\Pages;

use App\Modules\Masters\Filament\DepartmentResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = DepartmentResource::class;
}
