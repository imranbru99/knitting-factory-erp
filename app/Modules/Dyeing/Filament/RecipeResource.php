<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament;

use App\Modules\Dyeing\Models\Recipe;
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

class RecipeResource extends Resource
{
    protected static ?string $model = Recipe::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Dyeing';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';

    public static function moduleKey(): string
    {
        return 'dyeing';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Recipe')->columns(2)->schema([
                    Select::make('color_id')->label('Color Id')->relationship('color', 'name')->nullable()->searchable()->preload(),
                    Select::make('fabric_item_id')->label('Fabric Item Id')->relationship('fabric_item', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('name')->maxLength(255)->required(),
                    TextInput::make('liquor_ratio')->numeric(),
                    TextInput::make('cost_per_kg')->numeric(),
                    Repeater::make('lines')->relationship()->schema([
                        TextInput::make('chemical_name')->maxLength(255)->required(),
                        TextInput::make('gpl')->numeric(),
                        TextInput::make('cost')->numeric()
                    ])->columnSpanFull()->collapsible()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('color.name')->label('Color Id')->toggleable(),
                TextColumn::make('fabric_item.name')->label('Fabric Item Id')->toggleable(),
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('liquor_ratio')->sortable()->toggleable(),
                TextColumn::make('cost_per_kg')->sortable()->toggleable()
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
            'index' => RecipeResource\Pages\ListRecords::route('/'),
            'create' => RecipeResource\Pages\CreateRecord::route('/create'),
            'edit' => RecipeResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
