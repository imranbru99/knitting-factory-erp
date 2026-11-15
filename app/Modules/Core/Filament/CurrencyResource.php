<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament;

use App\Modules\Core\Models\Currency;
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

class CurrencyResource extends Resource
{
    protected static ?string $model = Currency::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Company';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'code';

    public static function moduleKey(): string
    {
        return 'core';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Currency')->columns(2)->schema([
                    TextInput::make('code')->maxLength(255)->required(),
                    TextInput::make('name')->maxLength(255)->required(),
                    TextInput::make('symbol')->maxLength(255),
                    TextInput::make('decimal_places')->numeric()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->searchable()->sortable()->toggleable(),
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('symbol')->searchable()->sortable()->toggleable(),
                TextColumn::make('decimal_places')->sortable()->toggleable()
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
        return ['code'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->code ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => CurrencyResource\Pages\ListRecords::route('/'),
            'create' => CurrencyResource\Pages\CreateRecord::route('/create'),
            'edit' => CurrencyResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
