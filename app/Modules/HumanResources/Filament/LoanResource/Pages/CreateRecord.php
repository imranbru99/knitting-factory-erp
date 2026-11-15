<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\LoanResource\Pages;

use App\Modules\HumanResources\Filament\LoanResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = LoanResource::class;
}
