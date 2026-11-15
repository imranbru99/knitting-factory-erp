<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament;

use App\Modules\Delivery\Models\PackingList;
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

class PackingListResource extends Resource
{
    protected static ?string $model = PackingList::class;

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
            Section::make('PackingList')->columns(2)->schema([
                    Select::make('sales_order_id')->label('Sales Order Id')->relationship('sales_order', 'number')->required()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('net_kg')->numeric(),
                    TextInput::make('gross_kg')->numeric(),
                    TextInput::make('yards')->numeric(),
                    Select::make('status')->options(['draft' => 'Draft', 'approved' => 'Approved'])->nullable(),
                    Repeater::make('lines')->relationship()->schema([
                        Select::make('roll_id')->label('Roll Id')->relationship('roll', 'number')->required()->searchable()->preload(),
                        TextInput::make('net_kg')->numeric(),
                        TextInput::make('yards')->numeric()
                    ])->columnSpanFull()->collapsible()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sales_order.number')->label('Sales Order Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('net_kg')->sortable()->toggleable(),
                TextColumn::make('gross_kg')->sortable()->toggleable(),
                TextColumn::make('yards')->sortable()->toggleable(),
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
            'index' => PackingListResource\Pages\ListRecords::route('/'),
            'create' => PackingListResource\Pages\CreateRecord::route('/create'),
            'edit' => PackingListResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
