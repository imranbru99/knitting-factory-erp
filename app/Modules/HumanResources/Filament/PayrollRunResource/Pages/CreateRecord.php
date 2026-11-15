<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\PayrollRunResource\Pages;

use App\Modules\HumanResources\Filament\PayrollRunResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = PayrollRunResource::class;
}
