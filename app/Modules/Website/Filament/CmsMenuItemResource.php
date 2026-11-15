<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament;

use App\Modules\Website\Models\CmsMenuItem;
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

class CmsMenuItemResource extends Resource
{
    protected static ?string $model = CmsMenuItem::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Website';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'label';

    public static function moduleKey(): string
    {
        return 'website';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('CmsMenuItem')->columns(2)->schema([
                    Select::make('cms_menu_id')->label('Cms Menu Id')->relationship('cms_menu', 'name')->required()->searchable()->preload(),
                    TextInput::make('label')->maxLength(255)->required(),
                    TextInput::make('label_bn')->maxLength(255),
                    TextInput::make('url')->maxLength(255)->required(),
                    TextInput::make('sort')->numeric()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cms_menu.name')->label('Cms Menu Id')->toggleable(),
                TextColumn::make('label')->searchable()->sortable()->toggleable(),
                TextColumn::make('label_bn')->searchable()->sortable()->toggleable(),
                TextColumn::make('url')->searchable()->sortable()->toggleable(),
                TextColumn::make('sort')->sortable()->toggleable()
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
            'index' => CmsMenuItemResource\Pages\ListRecords::route('/'),
            'create' => CmsMenuItemResource\Pages\CreateRecord::route('/create'),
            'edit' => CmsMenuItemResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
