<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament;

use App\Modules\Knitting\Models\KnittingProgram;
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

class KnittingProgramResource extends Resource
{
    protected static ?string $model = KnittingProgram::class;

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
            Section::make('KnittingProgram')->columns(2)->schema([
                    Select::make('sales_order_id')->label('Sales Order Id')->relationship('sales_order', 'number')->nullable()->searchable()->preload(),
                    Select::make('sales_order_line_id')->label('Sales Order Line Id')->relationship('sales_order_line', 'id')->nullable()->searchable()->preload(),
                    Select::make('machine_id')->label('Machine Id')->relationship('machine', 'code')->nullable()->searchable()->preload(),
                    Select::make('fabric_item_id')->label('Fabric Item Id')->relationship('fabric_item', 'name')->nullable()->searchable()->preload(),
                    Select::make('color_id')->label('Color Id')->relationship('color', 'name')->nullable()->searchable()->preload(),
                    Select::make('operator_id')->label('Operator Id')->relationship('operator', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('target_kg')->numeric(),
                    TextInput::make('target_gsm')->numeric(),
                    TextInput::make('stitch_length')->numeric(),
                    TextInput::make('dia')->numeric(),
                    Select::make('status')->options(['planned' => 'Planned', 'running' => 'Running', 'done' => 'Done', 'cancelled' => 'Cancelled'])->nullable(),
                    DateTimePicker::make('planned_start'),
                    DateTimePicker::make('planned_end'),
                    Textarea::make('special_instruction')->rows(3)->columnSpanFull(),
                    Repeater::make('lines')->relationship()->schema([
                        Select::make('yarn_lot_id')->label('Yarn Lot Id')->relationship('yarn_lot', 'lot_no')->nullable()->searchable()->preload(),
                        Select::make('yarn_item_id')->label('Yarn Item Id')->relationship('yarn_item', 'name')->nullable()->searchable()->preload(),
                        TextInput::make('ratio_pct')->numeric()
                    ])->columnSpanFull()->collapsible()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sales_order.number')->label('Sales Order Id')->toggleable(),
                TextColumn::make('sales_order_line.id')->label('Sales Order Line Id')->toggleable(),
                TextColumn::make('machine.code')->label('Machine Id')->toggleable(),
                TextColumn::make('fabric_item.name')->label('Fabric Item Id')->toggleable(),
                TextColumn::make('color.name')->label('Color Id')->toggleable(),
                TextColumn::make('operator.name')->label('Operator Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('target_kg')->sortable()->toggleable()
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
            'index' => KnittingProgramResource\Pages\ListRecords::route('/'),
            'create' => KnittingProgramResource\Pages\CreateRecord::route('/create'),
            'edit' => KnittingProgramResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
