<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\CompanyResource\Pages;

use App\Modules\Core\Filament\CompanyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
