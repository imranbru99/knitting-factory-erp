<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament;

use App\Modules\Delivery\Models\Trip;
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

class TripResource extends Resource
{
    protected static ?string $model = Trip::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Delivery';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'id';

    public static function moduleKey(): string
    {
        return 'delivery';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Trip')->columns(2)->schema([
                    Select::make('vehicle_id')->label('Vehicle Id')->relationship('vehicle', 'number')->nullable()->searchable()->preload(),
                    Select::make('delivery_challan_id')->label('Delivery Challan Id')->relationship('delivery_challan', 'number')->nullable()->searchable()->preload(),
                    TextInput::make('fuel_cost')->numeric(),
                    DatePicker::make('started_on'),
                    Textarea::make('note')->rows(3)->columnSpanFull()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vehicle.number')->label('Vehicle Id')->toggleable(),
                TextColumn::make('delivery_challan.number')->label('Delivery Challan Id')->toggleable(),
                TextColumn::make('fuel_cost')->sortable()->toggleable(),
                TextColumn::make('started_on')->sortable()->toggleable()
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
            'index' => TripResource\Pages\ListRecords::route('/'),
            'create' => TripResource\Pages\CreateRecord::route('/create'),
            'edit' => TripResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
