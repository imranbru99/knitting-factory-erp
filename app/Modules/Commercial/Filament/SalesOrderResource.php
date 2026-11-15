<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament;

use App\Modules\Commercial\Models\SalesOrder;
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

class SalesOrderResource extends Resource
{
    protected static ?string $model = SalesOrder::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Merchandising';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'number';

    public static function moduleKey(): string
    {
        return 'commercial';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('SalesOrder')->columns(2)->schema([
                    Select::make('party_id')->label('Party Id')->relationship('party', 'name')->required()->searchable()->preload(),
                    Select::make('unit_id')->label('Unit Id')->relationship('unit', 'name')->nullable()->searchable()->preload(),
                    Select::make('inquiry_id')->label('Inquiry Id')->relationship('inquiry', 'number')->nullable()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('buyer_po')->maxLength(255),
                    DatePicker::make('order_date'),
                    DatePicker::make('delivery_date'),
                    TextInput::make('currency_code')->maxLength(255),
                    TextInput::make('shipment_terms')->maxLength(255),
                    TextInput::make('tolerance_pct')->numeric(),
                    Select::make('yarn_source')->options(['own' => 'Own', 'buyer' => 'Buyer', 'mixed' => 'Mixed'])->nullable(),
                    Select::make('status')->options(['draft' => 'Draft', 'approved' => 'Approved', 'in_production' => 'In Production', 'closed' => 'Closed', 'cancelled' => 'Cancelled'])->nullable(),
                    Textarea::make('notes')->rows(3)->columnSpanFull(),
                    Repeater::make('lines')->relationship()->schema([
                        Select::make('fabric_item_id')->label('Fabric Item Id')->relationship('fabric_item', 'name')->nullable()->searchable()->preload(),
                        Select::make('color_id')->label('Color Id')->relationship('color', 'name')->nullable()->searchable()->preload(),
                        TextInput::make('gsm')->numeric(),
                        TextInput::make('dia')->numeric(),
                        TextInput::make('qty_kg')->numeric(),
                        TextInput::make('qty_yd')->numeric(),
                        TextInput::make('rate')->numeric(),
                        DatePicker::make('delivery_date')
                    ])->columnSpanFull()->collapsible()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('party.name')->label('Party Id')->toggleable(),
                TextColumn::make('unit.name')->label('Unit Id')->toggleable(),
                TextColumn::make('inquiry.number')->label('Inquiry Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('buyer_po')->searchable()->sortable()->toggleable(),
                TextColumn::make('order_date')->sortable()->toggleable(),
                TextColumn::make('delivery_date')->sortable()->toggleable(),
                TextColumn::make('currency_code')->searchable()->sortable()->toggleable()
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
        return ['number', 'buyer_po'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->number ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => SalesOrderResource\Pages\ListRecords::route('/'),
            'create' => SalesOrderResource\Pages\CreateRecord::route('/create'),
            'edit' => SalesOrderResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
