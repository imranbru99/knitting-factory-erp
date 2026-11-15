<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament\IssueRuleResource\Pages;

use App\Modules\Operations\Filament\IssueRuleResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = IssueRuleResource::class;
}
