<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament;

use App\Modules\Core\Models\DocumentSequence;
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

class DocumentSequenceResource extends Resource
{
    protected static ?string $model = DocumentSequence::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Company';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'doc_type';

    public static function moduleKey(): string
    {
        return 'core';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('DocumentSequence')->columns(2)->schema([
                    Select::make('unit_id')->label('Unit Id')->relationship('unit', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('doc_type')->maxLength(255)->required(),
                    TextInput::make('prefix')->maxLength(255)->required(),
                    TextInput::make('fy_code')->maxLength(255),
                    TextInput::make('last_number')->numeric()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unit.name')->label('Unit Id')->toggleable(),
                TextColumn::make('doc_type')->searchable()->sortable()->toggleable(),
                TextColumn::make('prefix')->searchable()->sortable()->toggleable(),
                TextColumn::make('fy_code')->searchable()->sortable()->toggleable(),
                TextColumn::make('last_number')->sortable()->toggleable()
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
        return ['doc_type'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->doc_type ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => DocumentSequenceResource\Pages\ListRecords::route('/'),
            'create' => DocumentSequenceResource\Pages\CreateRecord::route('/create'),
            'edit' => DocumentSequenceResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
