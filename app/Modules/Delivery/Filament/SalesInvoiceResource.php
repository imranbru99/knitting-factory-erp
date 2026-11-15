<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament;

use App\Modules\Delivery\Models\SalesInvoice;
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

class SalesInvoiceResource extends Resource
{
    protected static ?string $model = SalesInvoice::class;

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
            Section::make('SalesInvoice')->columns(2)->schema([
                    Select::make('delivery_challan_id')->label('Delivery Challan Id')->relationship('delivery_challan', 'number')->nullable()->searchable()->preload(),
                    Select::make('party_id')->label('Party Id')->relationship('party', 'name')->required()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('subtotal')->numeric(),
                    TextInput::make('vat')->numeric(),
                    TextInput::make('total')->numeric(),
                    TextInput::make('currency_code')->maxLength(255),
                    DatePicker::make('invoice_date'),
                    DatePicker::make('due_date'),
                    Select::make('status')->options(['draft' => 'Draft', 'posted' => 'Posted', 'paid' => 'Paid', 'partial' => 'Partial'])->nullable(),
                    Repeater::make('lines')->relationship()->schema([
                        TextInput::make('description')->maxLength(255),
                        TextInput::make('qty')->numeric(),
                        TextInput::make('rate')->numeric(),
                        TextInput::make('amount')->numeric()
                    ])->columnSpanFull()->collapsible()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('delivery_challan.number')->label('Delivery Challan Id')->toggleable(),
                TextColumn::make('party.name')->label('Party Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('subtotal')->sortable()->toggleable(),
                TextColumn::make('vat')->sortable()->toggleable(),
                TextColumn::make('total')->sortable()->toggleable(),
                TextColumn::make('currency_code')->searchable()->sortable()->toggleable(),
                TextColumn::make('invoice_date')->sortable()->toggleable()
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
            'index' => SalesInvoiceResource\Pages\ListRecords::route('/'),
            'create' => SalesInvoiceResource\Pages\CreateRecord::route('/create'),
            'edit' => SalesInvoiceResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
