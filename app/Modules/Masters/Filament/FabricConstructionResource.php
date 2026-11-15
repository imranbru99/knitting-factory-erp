<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament;

use App\Modules\Masters\Models\FabricConstruction;
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

class FabricConstructionResource extends Resource
{
    protected static ?string $model = FabricConstruction::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Masters';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';

    public static function moduleKey(): string
    {
        return 'masters';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('FabricConstruction')->columns(2)->schema([
                    TextInput::make('name')->maxLength(255)->required(),
                    TextInput::make('slug')->maxLength(255)->required(),
                    Select::make('family')->options(['single_jersey' => 'Single Jersey', 'lacoste' => 'Lacoste', 'pique' => 'Pique', 'rib' => 'Rib', 'interlock' => 'Interlock', 'fleece' => 'Fleece', 'terry' => 'Terry', 'french_terry' => 'French Terry', 'waffle' => 'Waffle', 'jacquard' => 'Jacquard', 'collar' => 'Collar', 'flat' => 'Flat'])->required()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('slug')->searchable()->sortable()->toggleable(),
                TextColumn::make('family')->searchable()->sortable()->toggleable()
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
        return ['name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->name ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => FabricConstructionResource\Pages\ListRecords::route('/'),
            'create' => FabricConstructionResource\Pages\CreateRecord::route('/create'),
            'edit' => FabricConstructionResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
