<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament;

use App\Modules\Core\Models\ExchangeRate;
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

class ExchangeRateResource extends Resource
{
    protected static ?string $model = ExchangeRate::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Company';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'currency_code';

    public static function moduleKey(): string
    {
        return 'core';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('ExchangeRate')->columns(2)->schema([
                    TextInput::make('currency_code')->maxLength(255)->required(),
                    DatePicker::make('rate_date'),
                    TextInput::make('rate_to_bdt')->numeric()->required()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('currency_code')->searchable()->sortable()->toggleable(),
                TextColumn::make('rate_date')->sortable()->toggleable(),
                TextColumn::make('rate_to_bdt')->sortable()->toggleable()
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
        return ['currency_code'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->currency_code ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => ExchangeRateResource\Pages\ListRecords::route('/'),
            'create' => ExchangeRateResource\Pages\CreateRecord::route('/create'),
            'edit' => ExchangeRateResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
