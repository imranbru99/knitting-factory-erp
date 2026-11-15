<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\SalaryStructureResource\Pages;

use App\Modules\HumanResources\Filament\SalaryStructureResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = SalaryStructureResource::class;
}
