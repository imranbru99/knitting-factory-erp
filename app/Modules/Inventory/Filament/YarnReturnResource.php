<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament;

use App\Modules\Inventory\Models\YarnReturn;
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

class YarnReturnResource extends Resource
{
    protected static ?string $model = YarnReturn::class;

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
            Section::make('YarnReturn')->columns(2)->schema([
                    Select::make('yarn_issue_id')->label('Yarn Issue Id')->relationship('yarn_issue', 'number')->nullable()->searchable()->preload(),
                    Select::make('yarn_lot_id')->label('Yarn Lot Id')->relationship('yarn_lot', 'lot_no')->required()->searchable()->preload(),
                    Select::make('warehouse_id')->label('Warehouse Id')->relationship('warehouse', 'name')->required()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('qty')->numeric()->required(),
                    TextInput::make('reason')->maxLength(255),
                    Select::make('status')->options(['draft' => 'Draft', 'approved' => 'Approved'])->nullable()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('yarn_issue.number')->label('Yarn Issue Id')->toggleable(),
                TextColumn::make('yarn_lot.lot_no')->label('Yarn Lot Id')->toggleable(),
                TextColumn::make('warehouse.name')->label('Warehouse Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('qty')->sortable()->toggleable(),
                TextColumn::make('reason')->searchable()->sortable()->toggleable(),
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
            'index' => YarnReturnResource\Pages\ListRecords::route('/'),
            'create' => YarnReturnResource\Pages\CreateRecord::route('/create'),
            'edit' => YarnReturnResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
