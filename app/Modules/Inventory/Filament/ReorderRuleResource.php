<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament;

use App\Modules\Inventory\Models\ReorderRule;
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

class ReorderRuleResource extends Resource
{
    protected static ?string $model = ReorderRule::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Yarn Store';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'id';

    public static function moduleKey(): string
    {
        return 'inventory';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('ReorderRule')->columns(2)->schema([
                    Select::make('yarn_item_id')->label('Yarn Item Id')->relationship('yarn_item', 'name')->required()->searchable()->preload(),
                    TextInput::make('min_qty')->numeric(),
                    TextInput::make('max_qty')->numeric(),
                    TextInput::make('lead_days')->numeric()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('yarn_item.name')->label('Yarn Item Id')->toggleable(),
                TextColumn::make('min_qty')->sortable()->toggleable(),
                TextColumn::make('max_qty')->sortable()->toggleable(),
                TextColumn::make('lead_days')->sortable()->toggleable()
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
        return [];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->id ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => ReorderRuleResource\Pages\ListRecords::route('/'),
            'create' => ReorderRuleResource\Pages\CreateRecord::route('/create'),
            'edit' => ReorderRuleResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
