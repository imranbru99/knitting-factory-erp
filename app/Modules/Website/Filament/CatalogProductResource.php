<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament;

use App\Modules\Website\Models\CatalogProduct;
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

class CatalogProductResource extends Resource
{
    protected static ?string $model = CatalogProduct::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Website';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'title';

    public static function moduleKey(): string
    {
        return 'website';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('CatalogProduct')->columns(2)->schema([
                    Select::make('fabric_item_id')->label('Fabric Item Id')->relationship('fabric_item', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('title')->maxLength(255)->required(),
                    TextInput::make('title_bn')->maxLength(255),
                    TextInput::make('slug')->maxLength(255),
                    TextInput::make('composition')->maxLength(255),
                    TextInput::make('gsm')->maxLength(255),
                    TextInput::make('uses')->maxLength(255),
                    Textarea::make('description')->rows(3)->columnSpanFull(),
                    Textarea::make('description_bn')->rows(3)->columnSpanFull(),
                    TextInput::make('image_path')->maxLength(255),
                    Toggle::make('published')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fabric_item.name')->label('Fabric Item Id')->toggleable(),
                TextColumn::make('title')->searchable()->sortable()->toggleable(),
                TextColumn::make('title_bn')->searchable()->sortable()->toggleable(),
                TextColumn::make('slug')->searchable()->sortable()->toggleable(),
                TextColumn::make('composition')->searchable()->sortable()->toggleable(),
                TextColumn::make('gsm')->searchable()->sortable()->toggleable(),
                TextColumn::make('uses')->searchable()->sortable()->toggleable(),
                TextColumn::make('image_path')->searchable()->sortable()->toggleable()
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
        return ['title'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->title ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => CatalogProductResource\Pages\ListRecords::route('/'),
            'create' => CatalogProductResource\Pages\CreateRecord::route('/create'),
            'edit' => CatalogProductResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
