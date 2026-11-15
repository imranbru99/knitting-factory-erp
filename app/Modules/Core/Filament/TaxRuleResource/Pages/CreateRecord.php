<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\TaxRuleResource\Pages;

use App\Modules\Core\Filament\TaxRuleResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = TaxRuleResource::class;
}
