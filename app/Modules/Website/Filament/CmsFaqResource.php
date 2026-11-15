<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament;

use App\Modules\Website\Models\CmsFaq;
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

class CmsFaqResource extends Resource
{
    protected static ?string $model = CmsFaq::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Website';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'question';

    public static function moduleKey(): string
    {
        return 'website';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('CmsFaq')->columns(2)->schema([
                    TextInput::make('question')->maxLength(255)->required(),
                    TextInput::make('question_bn')->maxLength(255),
                    Textarea::make('answer')->rows(3)->columnSpanFull(),
                    Textarea::make('answer_bn')->rows(3)->columnSpanFull(),
                    TextInput::make('sort')->numeric()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')->searchable()->sortable()->toggleable(),
                TextColumn::make('question_bn')->searchable()->sortable()->toggleable(),
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
        return ['question'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->question ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => CmsFaqResource\Pages\ListRecords::route('/'),
            'create' => CmsFaqResource\Pages\CreateRecord::route('/create'),
            'edit' => CmsFaqResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
