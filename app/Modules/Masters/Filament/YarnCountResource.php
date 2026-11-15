<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament;

use App\Modules\Masters\Models\YarnCount;
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

class YarnCountResource extends Resource
{
    protected static ?string $model = YarnCount::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Masters';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'label';

    public static function moduleKey(): string
    {
        return 'masters';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('YarnCount')->columns(2)->schema([
                    Select::make('system')->options(['Ne' => 'Ne', 'Nm' => 'Nm', 'Denier' => 'Denier', 'Dtex' => 'Dtex'])->required(),
                    TextInput::make('value')->maxLength(255)->required(),
                    TextInput::make('label')->maxLength(255)->required()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('system')->searchable()->sortable()->toggleable(),
                TextColumn::make('value')->searchable()->sortable()->toggleable(),
                TextColumn::make('label')->searchable()->sortable()->toggleable()
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
        return ['label'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->label ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => YarnCountResource\Pages\ListRecords::route('/'),
            'create' => YarnCountResource\Pages\CreateRecord::route('/create'),
            'edit' => YarnCountResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
