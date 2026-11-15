<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament;

use App\Modules\Core\Models\FinancialYear;
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

class FinancialYearResource extends Resource
{
    protected static ?string $model = FinancialYear::class;

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
            Section::make('FinancialYear')->columns(2)->schema([
                    TextInput::make('name')->maxLength(255)->required(),
                    TextInput::make('code')->maxLength(255)->required(),
                    DatePicker::make('starts_on'),
                    DatePicker::make('ends_on'),
                    Toggle::make('is_current'),
                    Toggle::make('is_locked')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('code')->searchable()->sortable()->toggleable(),
                TextColumn::make('starts_on')->sortable()->toggleable(),
                TextColumn::make('ends_on')->sortable()->toggleable(),
                IconColumn::make('is_current')->boolean()->toggleable(),
                IconColumn::make('is_locked')->boolean()->toggleable()
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
            'index' => FinancialYearResource\Pages\ListRecords::route('/'),
            'create' => FinancialYearResource\Pages\CreateRecord::route('/create'),
            'edit' => FinancialYearResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
