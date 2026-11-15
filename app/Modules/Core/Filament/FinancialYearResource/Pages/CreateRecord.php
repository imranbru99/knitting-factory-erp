<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\FinancialYearResource\Pages;

use App\Modules\Core\Filament\FinancialYearResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = FinancialYearResource::class;
}
