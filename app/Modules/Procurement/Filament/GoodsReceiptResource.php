<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament;

use App\Modules\Procurement\Models\GoodsReceipt;
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

class GoodsReceiptResource extends Resource
{
    protected static ?string $model = GoodsReceipt::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Procurement';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'number';

    public static function moduleKey(): string
    {
        return 'procurement';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('GoodsReceipt')->columns(2)->schema([
                    Select::make('purchase_order_id')->label('Purchase Order Id')->relationship('purchase_order', 'number')->nullable()->searchable()->preload(),
                    Select::make('party_id')->label('Party Id')->relationship('party', 'name')->nullable()->searchable()->preload(),
                    Select::make('warehouse_id')->label('Warehouse Id')->relationship('warehouse', 'name')->required()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('challan_no')->maxLength(255),
                    DatePicker::make('received_on'),
                    Select::make('status')->options(['draft' => 'Draft', 'approved' => 'Approved'])->nullable(),
                    Textarea::make('notes')->rows(3)->columnSpanFull(),
                    Repeater::make('lines')->relationship()->schema([
                        Select::make('purchase_order_line_id')->label('Purchase Order Line Id')->relationship('purchase_order_line', 'id')->nullable()->searchable()->preload(),
                        Select::make('yarn_item_id')->label('Yarn Item Id')->relationship('yarn_item', 'name')->required()->searchable()->preload(),
                        TextInput::make('lot_no')->maxLength(255)->required(),
                        TextInput::make('bags')->numeric(),
                        TextInput::make('cones')->numeric(),
                        TextInput::make('challan_weight')->numeric(),
                        TextInput::make('actual_weight')->numeric(),
                        TextInput::make('shortage')->numeric(),
                        Select::make('qc_status')->options(['pending' => 'Pending', 'pass' => 'Pass', 'hold' => 'Hold', 'reject' => 'Reject'])->nullable()
                    ])->columnSpanFull()->collapsible()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('purchase_order.number')->label('Purchase Order Id')->toggleable(),
                TextColumn::make('party.name')->label('Party Id')->toggleable(),
                TextColumn::make('warehouse.name')->label('Warehouse Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('challan_no')->searchable()->sortable()->toggleable(),
                TextColumn::make('received_on')->sortable()->toggleable(),
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
            'index' => GoodsReceiptResource\Pages\ListRecords::route('/'),
            'create' => GoodsReceiptResource\Pages\CreateRecord::route('/create'),
            'edit' => GoodsReceiptResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
