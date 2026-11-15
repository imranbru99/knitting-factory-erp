<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament;

use App\Modules\Core\Models\Attachment;
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

class AttachmentResource extends Resource
{
    protected static ?string $model = Attachment::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Company';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'original_name';

    public static function moduleKey(): string
    {
        return 'core';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Attachment')->columns(2)->schema([
                    TextInput::make('attachable_type')->maxLength(255)->required(),
                    TextInput::make('attachable_id')->numeric()->required(),
                    TextInput::make('disk')->maxLength(255),
                    TextInput::make('path')->maxLength(255)->required(),
                    TextInput::make('original_name')->maxLength(255),
                    TextInput::make('version')->numeric(),
                    DatePicker::make('expires_on')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('attachable_type')->searchable()->sortable()->toggleable(),
                TextColumn::make('attachable_id')->sortable()->toggleable(),
                TextColumn::make('disk')->searchable()->sortable()->toggleable(),
                TextColumn::make('path')->searchable()->sortable()->toggleable(),
                TextColumn::make('original_name')->searchable()->sortable()->toggleable(),
                TextColumn::make('version')->sortable()->toggleable(),
                TextColumn::make('expires_on')->sortable()->toggleable()
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
        return ['original_name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->original_name ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => AttachmentResource\Pages\ListRecords::route('/'),
            'create' => AttachmentResource\Pages\CreateRecord::route('/create'),
            'edit' => AttachmentResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
