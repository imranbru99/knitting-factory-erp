<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament;

use App\Modules\Website\Models\CmsBanner;
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

class CmsBannerResource extends Resource
{
    protected static ?string $model = CmsBanner::class;

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
            Section::make('CmsBanner')->columns(2)->schema([
                    TextInput::make('title')->maxLength(255)->required(),
                    TextInput::make('image_path')->maxLength(255),
                    TextInput::make('link')->maxLength(255),
                    TextInput::make('sort')->numeric(),
                    Toggle::make('is_active')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable()->toggleable(),
                TextColumn::make('image_path')->searchable()->sortable()->toggleable(),
                TextColumn::make('link')->searchable()->sortable()->toggleable(),
                TextColumn::make('sort')->sortable()->toggleable(),
                IconColumn::make('is_active')->boolean()->toggleable()
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
            'index' => CmsBannerResource\Pages\ListRecords::route('/'),
            'create' => CmsBannerResource\Pages\CreateRecord::route('/create'),
            'edit' => CmsBannerResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
