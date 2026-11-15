<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament;

use App\Modules\Inventory\Models\YarnTransfer;
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

class YarnTransferResource extends Resource
{
    protected static ?string $model = YarnTransfer::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Yarn Store';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'number';

    public static function moduleKey(): string
    {
        return 'inventory';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('YarnTransfer')->columns(2)->schema([
                    Select::make('from_sales_order_id')->label('From Sales Order Id')->relationship('fromOrder', 'number')->nullable()->searchable()->preload(),
                    Select::make('to_sales_order_id')->label('To Sales Order Id')->relationship('toOrder', 'number')->nullable()->searchable()->preload(),
                    Select::make('yarn_lot_id')->label('Yarn Lot Id')->relationship('yarn_lot', 'lot_no')->required()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('qty')->numeric(),
                    Select::make('status')->options(['draft' => 'Draft', 'approved' => 'Approved', 'rejected' => 'Rejected'])->nullable()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fromOrder.number')->label('From Sales Order Id')->toggleable(),
                TextColumn::make('toOrder.number')->label('To Sales Order Id')->toggleable(),
                TextColumn::make('yarn_lot.lot_no')->label('Yarn Lot Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('qty')->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable()
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
            'index' => YarnTransferResource\Pages\ListRecords::route('/'),
            'create' => YarnTransferResource\Pages\CreateRecord::route('/create'),
            'edit' => YarnTransferResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
