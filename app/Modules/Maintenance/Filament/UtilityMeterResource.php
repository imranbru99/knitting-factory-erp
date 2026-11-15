<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament;

use App\Modules\Maintenance\Models\UtilityMeter;
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

class UtilityMeterResource extends Resource
{
    protected static ?string $model = UtilityMeter::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Maintenance';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';

    public static function moduleKey(): string
    {
        return 'maintenance';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('UtilityMeter')->columns(2)->schema([
                    Select::make('kind')->options(['power' => 'Power', 'gas' => 'Gas', 'water' => 'Water', 'steam' => 'Steam', 'fuel' => 'Fuel'])->required(),
                    TextInput::make('name')->maxLength(255)->required()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kind')->searchable()->sortable()->toggleable(),
                TextColumn::make('name')->searchable()->sortable()->toggleable()
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
        return ['name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->name ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => UtilityMeterResource\Pages\ListRecords::route('/'),
            'create' => UtilityMeterResource\Pages\CreateRecord::route('/create'),
            'edit' => UtilityMeterResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
