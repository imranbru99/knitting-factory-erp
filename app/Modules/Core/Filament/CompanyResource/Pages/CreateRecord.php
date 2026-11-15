<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\CompanyResource\Pages;

use App\Modules\Core\Filament\CompanyResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = CompanyResource::class;
}
