<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament;

use App\Modules\Core\Models\UomConversion;
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

class UomConversionResource extends Resource
{
    protected static ?string $model = UomConversion::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Company';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'id';

    public static function moduleKey(): string
    {
        return 'core';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('UomConversion')->columns(2)->schema([
                    Select::make('from_uom_id')->label('From Uom Id')->relationship('fromUom', 'code')->required()->searchable()->preload(),
                    Select::make('to_uom_id')->label('To Uom Id')->relationship('toUom', 'code')->required()->searchable()->preload(),
                    TextInput::make('factor')->numeric()->required()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fromUom.code')->label('From Uom Id')->toggleable(),
                TextColumn::make('toUom.code')->label('To Uom Id')->toggleable(),
                TextColumn::make('factor')->sortable()->toggleable()
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
            'index' => UomConversionResource\Pages\ListRecords::route('/'),
            'create' => UomConversionResource\Pages\CreateRecord::route('/create'),
            'edit' => UomConversionResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
