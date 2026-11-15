<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament;

use App\Modules\Knitting\Models\Roll;
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

class RollResource extends Resource
{
    protected static ?string $model = Roll::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Knitting';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'number';

    public static function moduleKey(): string
    {
        return 'knitting';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Roll')->columns(2)->schema([
                    Select::make('knitting_program_id')->label('Knitting Program Id')->relationship('knitting_program', 'number')->nullable()->searchable()->preload(),
                    Select::make('machine_id')->label('Machine Id')->relationship('machine', 'code')->nullable()->searchable()->preload(),
                    Select::make('warehouse_id')->label('Warehouse Id')->relationship('warehouse', 'name')->nullable()->searchable()->preload(),
                    Select::make('sales_order_id')->label('Sales Order Id')->relationship('sales_order', 'number')->nullable()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('barcode')->maxLength(255),
                    TextInput::make('gross_kg')->numeric(),
                    TextInput::make('net_kg')->numeric(),
                    TextInput::make('gsm')->numeric(),
                    TextInput::make('dia')->numeric(),
                    TextInput::make('yards')->numeric(),
                    TextInput::make('grade')->maxLength(255),
                    Select::make('stage')->options(['grey' => 'Grey', 'inspected' => 'Inspected', 'issued_dye' => 'Issued Dye', 'finished' => 'Finished', 'packed' => 'Packed', 'delivered' => 'Delivered', 'rejected' => 'Rejected', 'hold' => 'Hold'])->nullable(),
                    DateTimePicker::make('produced_at')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('knitting_program.number')->label('Knitting Program Id')->toggleable(),
                TextColumn::make('machine.code')->label('Machine Id')->toggleable(),
                TextColumn::make('warehouse.name')->label('Warehouse Id')->toggleable(),
                TextColumn::make('sales_order.number')->label('Sales Order Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('barcode')->searchable()->sortable()->toggleable(),
                TextColumn::make('gross_kg')->sortable()->toggleable(),
                TextColumn::make('net_kg')->sortable()->toggleable()
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
        return ['number', 'barcode'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->number ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => RollResource\Pages\ListRecords::route('/'),
            'create' => RollResource\Pages\CreateRecord::route('/create'),
            'edit' => RollResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
