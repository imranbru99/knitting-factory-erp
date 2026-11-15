<?php

declare(strict_types=1);

namespace App\Modules\Waste\Filament;

use App\Modules\Waste\Models\WasteEntry;
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

class WasteEntryResource extends Resource
{
    protected static ?string $model = WasteEntry::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Waste';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'number';

    public static function moduleKey(): string
    {
        return 'waste';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('WasteEntry')->columns(2)->schema([
                    Select::make('sales_order_id')->label('Sales Order Id')->relationship('sales_order', 'number')->nullable()->searchable()->preload(),
                    Select::make('machine_id')->label('Machine Id')->relationship('machine', 'code')->nullable()->searchable()->preload(),
                    Select::make('warehouse_id')->label('Warehouse Id')->relationship('warehouse', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    Select::make('kind')->options(['yarn' => 'Yarn', 'fabric' => 'Fabric', 'cut_piece' => 'Cut Piece', 'lycra' => 'Lycra', 'packing' => 'Packing'])->required(),
                    TextInput::make('qty_kg')->numeric(),
                    TextInput::make('rate')->numeric(),
                    TextInput::make('value')->numeric(),
                    Select::make('status')->options(['draft' => 'Draft', 'approved' => 'Approved'])->nullable()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sales_order.number')->label('Sales Order Id')->toggleable(),
                TextColumn::make('machine.code')->label('Machine Id')->toggleable(),
                TextColumn::make('warehouse.name')->label('Warehouse Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('kind')->searchable()->sortable()->toggleable(),
                TextColumn::make('qty_kg')->sortable()->toggleable(),
                TextColumn::make('rate')->sortable()->toggleable(),
                TextColumn::make('value')->sortable()->toggleable()
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
            'index' => WasteEntryResource\Pages\ListRecords::route('/'),
            'create' => WasteEntryResource\Pages\CreateRecord::route('/create'),
            'edit' => WasteEntryResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
