<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament;

use App\Modules\Dyeing\Models\ChemicalIssue;
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

class ChemicalIssueResource extends Resource
{
    protected static ?string $model = ChemicalIssue::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Dyeing';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'chemical_name';

    public static function moduleKey(): string
    {
        return 'dyeing';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('ChemicalIssue')->columns(2)->schema([
                    Select::make('dye_batch_id')->label('Dye Batch Id')->relationship('dye_batch', 'number')->required()->searchable()->preload(),
                    TextInput::make('chemical_name')->maxLength(255)->required(),
                    TextInput::make('qty')->numeric(),
                    TextInput::make('recipe_qty')->numeric()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('dye_batch.number')->label('Dye Batch Id')->toggleable(),
                TextColumn::make('chemical_name')->searchable()->sortable()->toggleable(),
                TextColumn::make('qty')->sortable()->toggleable(),
                TextColumn::make('recipe_qty')->sortable()->toggleable()
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
        return ['chemical_name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->chemical_name ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => ChemicalIssueResource\Pages\ListRecords::route('/'),
            'create' => ChemicalIssueResource\Pages\CreateRecord::route('/create'),
            'edit' => ChemicalIssueResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
