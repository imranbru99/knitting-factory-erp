<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament;

use App\Modules\Inventory\Models\StockLedger;
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

class StockLedgerResource extends Resource
{
    protected static ?string $model = StockLedger::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Yarn Store';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'id';

    public static function moduleKey(): string
    {
        return 'inventory';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('StockLedger')->columns(2)->schema([
                    Select::make('warehouse_id')->label('Warehouse Id')->relationship('warehouse', 'name')->required()->searchable()->preload(),
                    Select::make('unit_id')->label('Unit Id')->relationship('unit', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('stock_type')->maxLength(255)->required(),
                    TextInput::make('item_id')->numeric()->required(),
                    TextInput::make('lot_id')->numeric(),
                    TextInput::make('qty_in')->numeric(),
                    TextInput::make('qty_out')->numeric(),
                    TextInput::make('balance_qty')->numeric(),
                    TextInput::make('rate')->numeric(),
                    TextInput::make('amount')->numeric(),
                    TextInput::make('ref_type')->maxLength(255),
                    TextInput::make('ref_id')->numeric(),
                    TextInput::make('movement_key')->maxLength(255),
                    DateTimePicker::make('moved_at')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('warehouse.name')->label('Warehouse Id')->toggleable(),
                TextColumn::make('unit.name')->label('Unit Id')->toggleable(),
                TextColumn::make('stock_type')->searchable()->sortable()->toggleable(),
                TextColumn::make('item_id')->sortable()->toggleable(),
                TextColumn::make('lot_id')->sortable()->toggleable(),
                TextColumn::make('qty_in')->sortable()->toggleable(),
                TextColumn::make('qty_out')->sortable()->toggleable(),
                TextColumn::make('balance_qty')->sortable()->toggleable()
            ])
            ->recordActions([
                
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['stock_type', 'movement_key'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->id ?? $record->getKey());
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => StockLedgerResource\Pages\ListRecords::route('/'),
        ];
    }
}
