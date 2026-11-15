<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament;

use App\Modules\Maintenance\Models\UtilityReading;
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

class UtilityReadingResource extends Resource
{
    protected static ?string $model = UtilityReading::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Maintenance';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'id';

    public static function moduleKey(): string
    {
        return 'maintenance';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('UtilityReading')->columns(2)->schema([
                    Select::make('utility_meter_id')->label('Utility Meter Id')->relationship('utility_meter', 'name')->required()->searchable()->preload(),
                    Select::make('shift_id')->label('Shift Id')->relationship('shift', 'name')->nullable()->searchable()->preload(),
                    DatePicker::make('read_on'),
                    TextInput::make('reading')->numeric(),
                    TextInput::make('consumption')->numeric(),
                    TextInput::make('cost')->numeric(),
                    TextInput::make('production_kg')->numeric()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('utility_meter.name')->label('Utility Meter Id')->toggleable(),
                TextColumn::make('shift.name')->label('Shift Id')->toggleable(),
                TextColumn::make('read_on')->sortable()->toggleable(),
                TextColumn::make('reading')->sortable()->toggleable(),
                TextColumn::make('consumption')->sortable()->toggleable(),
                TextColumn::make('cost')->sortable()->toggleable(),
                TextColumn::make('production_kg')->sortable()->toggleable()
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
            'index' => UtilityReadingResource\Pages\ListRecords::route('/'),
            'create' => UtilityReadingResource\Pages\CreateRecord::route('/create'),
            'edit' => UtilityReadingResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
