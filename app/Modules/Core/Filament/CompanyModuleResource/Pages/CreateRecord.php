<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\CompanyModuleResource\Pages;

use App\Modules\Core\Filament\CompanyModuleResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = CompanyModuleResource::class;
}
