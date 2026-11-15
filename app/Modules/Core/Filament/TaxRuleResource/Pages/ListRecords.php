<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\TaxRuleResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\TaxRuleResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = TaxRuleResource::class;
}
