<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament;

use App\Modules\Commercial\Models\Bom;
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

class BomResource extends Resource
{
    protected static ?string $model = Bom::class;

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
            Section::make('Bom')->columns(2)->schema([
                    Select::make('sales_order_id')->label('Sales Order Id')->relationship('sales_order', 'number')->required()->searchable()->preload(),
                    Select::make('fabric_item_id')->label('Fabric Item Id')->relationship('fabric_item', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('process_loss_pct')->numeric(),
                    TextInput::make('wastage_pct')->numeric(),
                    Select::make('status')->options(['draft' => 'Draft', 'approved' => 'Approved'])->nullable(),
                    Repeater::make('lines')->relationship()->schema([
                        Select::make('yarn_item_id')->label('Yarn Item Id')->relationship('yarn_item', 'name')->nullable()->searchable()->preload(),
                        TextInput::make('ratio_pct')->numeric(),
                        TextInput::make('requirement_kg')->numeric(),
                        Toggle::make('is_lycra')
                    ])->columnSpanFull()->collapsible()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sales_order.number')->label('Sales Order Id')->toggleable(),
                TextColumn::make('fabric_item.name')->label('Fabric Item Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('process_loss_pct')->sortable()->toggleable(),
                TextColumn::make('wastage_pct')->sortable()->toggleable(),
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
            'index' => BomResource\Pages\ListRecords::route('/'),
            'create' => BomResource\Pages\CreateRecord::route('/create'),
            'edit' => BomResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
