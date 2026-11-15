<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\ApprovalWorkflowResource\Pages;

use App\Modules\Core\Filament\ApprovalWorkflowResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = ApprovalWorkflowResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
