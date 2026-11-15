<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament;

use App\Modules\Procurement\Models\SupplierBill;
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

class SupplierBillResource extends Resource
{
    protected static ?string $model = SupplierBill::class;

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
            Section::make('SupplierBill')->columns(2)->schema([
                    Select::make('party_id')->label('Party Id')->relationship('party', 'name')->required()->searchable()->preload(),
                    Select::make('purchase_order_id')->label('Purchase Order Id')->relationship('purchase_order', 'number')->nullable()->searchable()->preload(),
                    Select::make('goods_receipt_id')->label('Goods Receipt Id')->relationship('goods_receipt', 'number')->nullable()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('amount')->numeric(),
                    Select::make('status')->options(['draft' => 'Draft', 'matched' => 'Matched', 'mismatch' => 'Mismatch', 'posted' => 'Posted'])->nullable(),
                    TextInput::make('match_status')->maxLength(255),
                    Textarea::make('notes')->rows(3)->columnSpanFull(),
                    Repeater::make('lines')->relationship()->schema([
                        TextInput::make('description')->maxLength(255),
                        TextInput::make('qty')->numeric(),
                        TextInput::make('amount')->numeric()
                    ])->columnSpanFull()->collapsible()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('party.name')->label('Party Id')->toggleable(),
                TextColumn::make('purchase_order.number')->label('Purchase Order Id')->toggleable(),
                TextColumn::make('goods_receipt.number')->label('Goods Receipt Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('amount')->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable(),
                TextColumn::make('match_status')->searchable()->sortable()->toggleable()
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
            'index' => SupplierBillResource\Pages\ListRecords::route('/'),
            'create' => SupplierBillResource\Pages\CreateRecord::route('/create'),
            'edit' => SupplierBillResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
