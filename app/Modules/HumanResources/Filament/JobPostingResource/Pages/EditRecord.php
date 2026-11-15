<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\JobPostingResource\Pages;

use App\Modules\HumanResources\Filament\JobPostingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = JobPostingResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
