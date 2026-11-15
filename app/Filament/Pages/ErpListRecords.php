<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Modules\Support\SpreadsheetExport;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ErpListRecords extends ListRecords
{
    protected static bool $isDiscovered = false;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('exportExcel')
                ->label('Export')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function (): BinaryFileResponse {
                    $model = static::getResource()::getModel();

                    return app(SpreadsheetExport::class)->download(new $model);
                }),
        ];
    }
}
