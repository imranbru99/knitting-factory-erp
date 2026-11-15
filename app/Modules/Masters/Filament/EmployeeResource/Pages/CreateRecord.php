<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament\EmployeeResource\Pages;

use App\Modules\Masters\Filament\EmployeeResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = EmployeeResource::class;
}
