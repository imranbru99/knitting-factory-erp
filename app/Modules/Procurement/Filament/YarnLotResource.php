<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament;

use App\Modules\Procurement\Models\YarnLot;
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

class YarnLotResource extends Resource
{
    protected static ?string $model = YarnLot::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Procurement';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'lot_no';

    public static function moduleKey(): string
    {
        return 'procurement';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('YarnLot')->columns(2)->schema([
                    Select::make('yarn_item_id')->label('Yarn Item Id')->relationship('yarn_item', 'name')->required()->searchable()->preload(),
                    Select::make('party_id')->label('Party Id')->relationship('party', 'name')->nullable()->searchable()->preload(),
                    Select::make('warehouse_id')->label('Warehouse Id')->relationship('warehouse', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('lot_no')->maxLength(255)->required(),
                    DatePicker::make('received_on'),
                    Select::make('qc_status')->options(['pending' => 'Pending', 'pass' => 'Pass', 'hold' => 'Hold', 'reject' => 'Reject'])->nullable(),
                    TextInput::make('count_actual')->maxLength(255),
                    TextInput::make('csp')->numeric(),
                    TextInput::make('u_percent')->numeric(),
                    TextInput::make('moisture')->numeric(),
                    Textarea::make('shade_note')->rows(3)->columnSpanFull(),
                    TextInput::make('barcode')->maxLength(255),
                    TextInput::make('net_kg')->numeric()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('yarn_item.name')->label('Yarn Item Id')->toggleable(),
                TextColumn::make('party.name')->label('Party Id')->toggleable(),
                TextColumn::make('warehouse.name')->label('Warehouse Id')->toggleable(),
                TextColumn::make('lot_no')->searchable()->sortable()->toggleable(),
                TextColumn::make('received_on')->sortable()->toggleable(),
                TextColumn::make('qc_status')->searchable()->sortable()->toggleable(),
                TextColumn::make('count_actual')->searchable()->sortable()->toggleable(),
                TextColumn::make('csp')->sortable()->toggleable()
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
        return ['lot_no', 'barcode'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->lot_no ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => YarnLotResource\Pages\ListRecords::route('/'),
            'create' => YarnLotResource\Pages\CreateRecord::route('/create'),
            'edit' => YarnLotResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
