<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament\IssueRuleResource\Pages;

use App\Modules\Operations\Filament\IssueRuleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = IssueRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
