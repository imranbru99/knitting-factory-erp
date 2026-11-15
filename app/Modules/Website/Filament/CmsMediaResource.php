<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament;

use App\Modules\Website\Models\CmsMedia;
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

class CmsMediaResource extends Resource
{
    protected static ?string $model = CmsMedia::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Website';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'alt';

    public static function moduleKey(): string
    {
        return 'website';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('CmsMedia')->columns(2)->schema([
                    TextInput::make('path')->maxLength(255)->required(),
                    TextInput::make('alt')->maxLength(255),
                    TextInput::make('alt_bn')->maxLength(255)
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('path')->searchable()->sortable()->toggleable(),
                TextColumn::make('alt')->searchable()->sortable()->toggleable(),
                TextColumn::make('alt_bn')->searchable()->sortable()->toggleable()
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
        return ['alt'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->alt ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => CmsMediaResource\Pages\ListRecords::route('/'),
            'create' => CmsMediaResource\Pages\CreateRecord::route('/create'),
            'edit' => CmsMediaResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
