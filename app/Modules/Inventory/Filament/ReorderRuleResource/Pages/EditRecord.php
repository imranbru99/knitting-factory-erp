<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament\ReorderRuleResource\Pages;

use App\Modules\Inventory\Filament\ReorderRuleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = ReorderRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
