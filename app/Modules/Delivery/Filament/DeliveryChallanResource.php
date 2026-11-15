<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament;

use App\Modules\Delivery\Models\DeliveryChallan;
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

class DeliveryChallanResource extends Resource
{
    protected static ?string $model = DeliveryChallan::class;

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
            Section::make('DeliveryChallan')->columns(2)->schema([
                    Select::make('packing_list_id')->label('Packing List Id')->relationship('packing_list', 'number')->nullable()->searchable()->preload(),
                    Select::make('party_id')->label('Party Id')->relationship('party', 'name')->required()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('vehicle_no')->maxLength(255),
                    TextInput::make('driver')->maxLength(255),
                    TextInput::make('mushak')->maxLength(255),
                    Select::make('status')->options(['draft' => 'Draft', 'approved' => 'Approved', 'delivered' => 'Delivered'])->nullable(),
                    Repeater::make('lines')->relationship()->schema([
                        Select::make('roll_id')->label('Roll Id')->relationship('roll', 'number')->required()->searchable()->preload(),
                        TextInput::make('kg')->numeric()
                    ])->columnSpanFull()->collapsible()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('packing_list.number')->label('Packing List Id')->toggleable(),
                TextColumn::make('party.name')->label('Party Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('vehicle_no')->searchable()->sortable()->toggleable(),
                TextColumn::make('driver')->searchable()->sortable()->toggleable(),
                TextColumn::make('mushak')->searchable()->sortable()->toggleable(),
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
            'index' => DeliveryChallanResource\Pages\ListRecords::route('/'),
            'create' => DeliveryChallanResource\Pages\CreateRecord::route('/create'),
            'edit' => DeliveryChallanResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
