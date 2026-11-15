<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament\ReorderRuleResource\Pages;

use App\Modules\Inventory\Filament\ReorderRuleResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = ReorderRuleResource::class;
}
