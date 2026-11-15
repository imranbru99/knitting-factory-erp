<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament;

use App\Modules\Delivery\Models\Vehicle;
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

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Delivery';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'number';

    public static function moduleKey(): string
    {
        return 'delivery';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Vehicle')->columns(2)->schema([
                    Select::make('transporter_id')->label('Transporter Id')->relationship('transporter', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255)->required(),
                    TextInput::make('capacity_kg')->numeric()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('transporter.name')->label('Transporter Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('capacity_kg')->sortable()->toggleable()
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
        return ['number'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->number ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => VehicleResource\Pages\ListRecords::route('/'),
            'create' => VehicleResource\Pages\CreateRecord::route('/create'),
            'edit' => VehicleResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
