<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament;

use App\Modules\Procurement\Models\Shipment;
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

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Procurement';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'bl_no';

    public static function moduleKey(): string
    {
        return 'procurement';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Shipment')->columns(2)->schema([
                    Select::make('import_lc_id')->label('Import Lc Id')->relationship('import_lc', 'number')->nullable()->searchable()->preload(),
                    TextInput::make('bl_no')->maxLength(255),
                    DatePicker::make('eta'),
                    TextInput::make('duty')->numeric(),
                    TextInput::make('freight')->numeric(),
                    TextInput::make('landed_cost')->numeric()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('import_lc.number')->label('Import Lc Id')->toggleable(),
                TextColumn::make('bl_no')->searchable()->sortable()->toggleable(),
                TextColumn::make('eta')->sortable()->toggleable(),
                TextColumn::make('duty')->sortable()->toggleable(),
                TextColumn::make('freight')->sortable()->toggleable(),
                TextColumn::make('landed_cost')->sortable()->toggleable()
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
        return ['bl_no'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->bl_no ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => ShipmentResource\Pages\ListRecords::route('/'),
            'create' => ShipmentResource\Pages\CreateRecord::route('/create'),
            'edit' => ShipmentResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
