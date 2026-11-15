<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament;

use App\Modules\Dyeing\Models\DyeBatch;
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

class DyeBatchResource extends Resource
{
    protected static ?string $model = DyeBatch::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Dyeing';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'number';

    public static function moduleKey(): string
    {
        return 'dyeing';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('DyeBatch')->columns(2)->schema([
                    Select::make('dye_machine_id')->label('Dye Machine Id')->relationship('dye_machine', 'code')->nullable()->searchable()->preload(),
                    Select::make('recipe_id')->label('Recipe Id')->relationship('recipe', 'name')->nullable()->searchable()->preload(),
                    Select::make('color_id')->label('Color Id')->relationship('color', 'name')->nullable()->searchable()->preload(),
                    Select::make('party_id')->label('Party Id')->relationship('party', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('input_kg')->numeric(),
                    TextInput::make('output_kg')->numeric(),
                    TextInput::make('process_loss_pct')->numeric(),
                    TextInput::make('shade_de')->numeric(),
                    Select::make('status')->options(['planned' => 'Planned', 'running' => 'Running', 'finished' => 'Finished', 'hold' => 'Hold'])->nullable(),
                    Toggle::make('is_subcontract')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('dye_machine.code')->label('Dye Machine Id')->toggleable(),
                TextColumn::make('recipe.name')->label('Recipe Id')->toggleable(),
                TextColumn::make('color.name')->label('Color Id')->toggleable(),
                TextColumn::make('party.name')->label('Party Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('input_kg')->sortable()->toggleable(),
                TextColumn::make('output_kg')->sortable()->toggleable(),
                TextColumn::make('process_loss_pct')->sortable()->toggleable()
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
            'index' => DyeBatchResource\Pages\ListRecords::route('/'),
            'create' => DyeBatchResource\Pages\CreateRecord::route('/create'),
            'edit' => DyeBatchResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
