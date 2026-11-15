<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament\IssueRuleResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Operations\Filament\IssueRuleResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = IssueRuleResource::class;
}
