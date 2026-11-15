<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament;

use App\Modules\Maintenance\Models\SparePart;
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

class SparePartResource extends Resource
{
    protected static ?string $model = SparePart::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Maintenance';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';

    public static function moduleKey(): string
    {
        return 'maintenance';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('SparePart')->columns(2)->schema([
                    TextInput::make('code')->maxLength(255)->required(),
                    TextInput::make('name')->maxLength(255)->required(),
                    TextInput::make('gauge')->maxLength(255),
                    TextInput::make('min_qty')->numeric(),
                    TextInput::make('max_qty')->numeric(),
                    TextInput::make('rate')->numeric()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->searchable()->sortable()->toggleable(),
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('gauge')->searchable()->sortable()->toggleable(),
                TextColumn::make('min_qty')->sortable()->toggleable(),
                TextColumn::make('max_qty')->sortable()->toggleable(),
                TextColumn::make('rate')->sortable()->toggleable()
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
            'index' => SparePartResource\Pages\ListRecords::route('/'),
            'create' => SparePartResource\Pages\CreateRecord::route('/create'),
            'edit' => SparePartResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
