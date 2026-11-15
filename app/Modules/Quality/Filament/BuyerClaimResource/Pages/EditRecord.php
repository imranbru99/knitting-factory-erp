<?php

declare(strict_types=1);

namespace App\Modules\Quality\Filament\BuyerClaimResource\Pages;

use App\Modules\Quality\Filament\BuyerClaimResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as EditRecordPage;

class EditRecord extends EditRecordPage
{
    protected static string $resource = BuyerClaimResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
