<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament;

use App\Modules\Accounts\Models\PeriodLock;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PeriodLockResource extends Resource
{
    protected static ?string $model = PeriodLock::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Accounts';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'id';

    public static function moduleKey(): string
    {
        return 'accounts';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('PeriodLock')->columns(2)->schema([
                    TextInput::make('year')->numeric()->required(),
                    TextInput::make('month')->numeric()->required(),
                    DateTimePicker::make('locked_at')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year')->sortable()->toggleable(),
                TextColumn::make('month')->sortable()->toggleable(),
                TextColumn::make('locked_at')->sortable()->toggleable()
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->id ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => PeriodLockResource\Pages\ListRecords::route('/'),
            'create' => PeriodLockResource\Pages\CreateRecord::route('/create'),
            'edit' => PeriodLockResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
