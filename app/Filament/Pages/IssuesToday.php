<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Modules\Operations\Models\Issue;
use BackedEnum;
use Filament\Pages\Page;
use UnitEnum;

class IssuesToday extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static string|UnitEnum|null $navigationGroup = 'Operations';

    protected static ?string $navigationLabel = 'Issues Today';

    protected static ?string $title = 'Issues Today';

    protected string $view = 'filament.pages.issues-today';

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'issues' => Issue::query()->where('status', 'open')->latest()->limit(50)->get(),
        ];
    }
}
