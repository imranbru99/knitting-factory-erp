<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament;

use App\Modules\Core\Models\Warehouse;
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

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Company';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';

    public static function moduleKey(): string
    {
        return 'core';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Warehouse')->columns(2)->schema([
                    Select::make('unit_id')->label('Unit Id')->relationship('unit', 'name')->required()->searchable()->preload(),
                    TextInput::make('code')->maxLength(255)->required(),
                    TextInput::make('name')->maxLength(255)->required(),
                    Select::make('kind')->options(['yarn' => 'Yarn', 'grey' => 'Grey', 'finished' => 'Finished', 'spare' => 'Spare', 'waste' => 'Waste', 'chemical' => 'Chemical'])->required()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unit.name')->label('Unit Id')->toggleable(),
                TextColumn::make('code')->searchable()->sortable()->toggleable(),
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('kind')->searchable()->sortable()->toggleable()
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
        return ['code', 'name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->name ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => WarehouseResource\Pages\ListRecords::route('/'),
            'create' => WarehouseResource\Pages\CreateRecord::route('/create'),
            'edit' => WarehouseResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
