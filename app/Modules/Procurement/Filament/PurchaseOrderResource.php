<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament;

use App\Modules\Procurement\Models\PurchaseOrder;
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

class PurchaseOrderResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;

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
            Section::make('PurchaseOrder')->columns(2)->schema([
                    Select::make('party_id')->label('Party Id')->relationship('party', 'name')->required()->searchable()->preload(),
                    Select::make('requisition_id')->label('Requisition Id')->relationship('requisition', 'number')->nullable()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    Select::make('status')->options(['draft' => 'Draft', 'submitted' => 'Submitted', 'approved' => 'Approved', 'partial' => 'Partial', 'received' => 'Received', 'cancelled' => 'Cancelled'])->nullable(),
                    TextInput::make('currency_code')->maxLength(255),
                    DatePicker::make('order_date'),
                    DatePicker::make('expected_on'),
                    Textarea::make('notes')->rows(3)->columnSpanFull(),
                    Repeater::make('lines')->relationship()->schema([
                        Select::make('yarn_item_id')->label('Yarn Item Id')->relationship('yarn_item', 'name')->required()->searchable()->preload(),
                        TextInput::make('qty')->numeric(),
                        TextInput::make('rate')->numeric(),
                        TextInput::make('received_qty')->numeric()
                    ])->columnSpanFull()->collapsible()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('party.name')->label('Party Id')->toggleable(),
                TextColumn::make('requisition.number')->label('Requisition Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable(),
                TextColumn::make('currency_code')->searchable()->sortable()->toggleable(),
                TextColumn::make('order_date')->sortable()->toggleable(),
                TextColumn::make('expected_on')->sortable()->toggleable()
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
            'index' => PurchaseOrderResource\Pages\ListRecords::route('/'),
            'create' => PurchaseOrderResource\Pages\CreateRecord::route('/create'),
            'edit' => PurchaseOrderResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
