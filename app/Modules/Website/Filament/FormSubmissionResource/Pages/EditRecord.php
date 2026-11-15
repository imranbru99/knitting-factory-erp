<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\FormSubmissionResource\Pages;

use App\Modules\Website\Filament\FormSubmissionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = FormSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
