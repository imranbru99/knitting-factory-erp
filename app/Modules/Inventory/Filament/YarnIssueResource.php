<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament;

use App\Modules\Inventory\Models\YarnIssue;
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

class YarnIssueResource extends Resource
{
    protected static ?string $model = YarnIssue::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Yarn Store';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'number';

    public static function moduleKey(): string
    {
        return 'inventory';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('YarnIssue')->columns(2)->schema([
                    Select::make('knitting_program_id')->label('Knitting Program Id')->relationship('knitting_program', 'number')->nullable()->searchable()->preload(),
                    Select::make('warehouse_id')->label('Warehouse Id')->relationship('warehouse', 'name')->required()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    DatePicker::make('issued_on'),
                    Select::make('status')->options(['draft' => 'Draft', 'approved' => 'Approved'])->nullable(),
                    Textarea::make('notes')->rows(3)->columnSpanFull(),
                    Repeater::make('lines')->relationship()->schema([
                        Select::make('yarn_lot_id')->label('Yarn Lot Id')->relationship('yarn_lot', 'lot_no')->required()->searchable()->preload(),
                        Select::make('yarn_item_id')->label('Yarn Item Id')->relationship('yarn_item', 'name')->nullable()->searchable()->preload(),
                        TextInput::make('qty')->numeric(),
                        Toggle::make('approved_mix')
                    ])->columnSpanFull()->collapsible()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('knitting_program.number')->label('Knitting Program Id')->toggleable(),
                TextColumn::make('warehouse.name')->label('Warehouse Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('issued_on')->sortable()->toggleable(),
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
            'index' => YarnIssueResource\Pages\ListRecords::route('/'),
            'create' => YarnIssueResource\Pages\CreateRecord::route('/create'),
            'edit' => YarnIssueResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
