<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament;

use App\Modules\Website\Models\CmsPage;
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

class CmsPageResource extends Resource
{
    protected static ?string $model = CmsPage::class;

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
            Section::make('CmsPage')->columns(2)->schema([
                    TextInput::make('title')->maxLength(255)->required(),
                    TextInput::make('title_bn')->maxLength(255),
                    TextInput::make('slug')->maxLength(255),
                    Textarea::make('body')->rows(3)->columnSpanFull(),
                    Textarea::make('body_bn')->rows(3)->columnSpanFull(),
                    TextInput::make('seo_title')->maxLength(255),
                    Textarea::make('seo_description')->rows(3)->columnSpanFull(),
                    DateTimePicker::make('published_at'),
                    Select::make('status')->options(['draft' => 'Draft', 'published' => 'Published'])->nullable()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable()->toggleable(),
                TextColumn::make('title_bn')->searchable()->sortable()->toggleable(),
                TextColumn::make('slug')->searchable()->sortable()->toggleable(),
                TextColumn::make('seo_title')->searchable()->sortable()->toggleable(),
                TextColumn::make('published_at')->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable()
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
            'index' => CmsPageResource\Pages\ListRecords::route('/'),
            'create' => CmsPageResource\Pages\CreateRecord::route('/create'),
            'edit' => CmsPageResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
