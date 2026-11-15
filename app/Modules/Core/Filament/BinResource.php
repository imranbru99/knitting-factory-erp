<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament;

use App\Modules\Core\Models\Bin;
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

class BinResource extends Resource
{
    protected static ?string $model = Bin::class;

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
            Section::make('Bin')->columns(2)->schema([
                    Select::make('rack_id')->label('Rack Id')->relationship('rack', 'name')->required()->searchable()->preload(),
                    TextInput::make('code')->maxLength(255)->required()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rack.name')->label('Rack Id')->toggleable(),
                TextColumn::make('code')->searchable()->sortable()->toggleable()
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
            'index' => BinResource\Pages\ListRecords::route('/'),
            'create' => BinResource\Pages\CreateRecord::route('/create'),
            'edit' => BinResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
