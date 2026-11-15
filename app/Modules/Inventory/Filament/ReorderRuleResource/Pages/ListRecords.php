<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament\ReorderRuleResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Inventory\Filament\ReorderRuleResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = ReorderRuleResource::class;
}
