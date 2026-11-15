<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament;

use App\Modules\Dyeing\Models\ShadeMatch;
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

class ShadeMatchResource extends Resource
{
    protected static ?string $model = ShadeMatch::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Dyeing';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'id';

    public static function moduleKey(): string
    {
        return 'dyeing';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('ShadeMatch')->columns(2)->schema([
                    Select::make('dye_batch_id')->label('Dye Batch Id')->relationship('dye_batch', 'number')->required()->searchable()->preload(),
                    TextInput::make('l_star')->numeric(),
                    TextInput::make('a_star')->numeric(),
                    TextInput::make('b_star')->numeric(),
                    TextInput::make('delta_e')->numeric(),
                    Toggle::make('approved')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('dye_batch.number')->label('Dye Batch Id')->toggleable(),
                TextColumn::make('l_star')->sortable()->toggleable(),
                TextColumn::make('a_star')->sortable()->toggleable(),
                TextColumn::make('b_star')->sortable()->toggleable(),
                TextColumn::make('delta_e')->sortable()->toggleable(),
                IconColumn::make('approved')->boolean()->toggleable()
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
            'index' => ShadeMatchResource\Pages\ListRecords::route('/'),
            'create' => ShadeMatchResource\Pages\CreateRecord::route('/create'),
            'edit' => ShadeMatchResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
