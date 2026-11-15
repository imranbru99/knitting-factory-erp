<?php

declare(strict_types=1);

namespace App\Modules\Quality\Filament;

use App\Modules\Quality\Models\ComplianceDocument;
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

class ComplianceDocumentResource extends Resource
{
    protected static ?string $model = ComplianceDocument::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Quality';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';

    public static function moduleKey(): string
    {
        return 'quality';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('ComplianceDocument')->columns(2)->schema([
                    TextInput::make('name')->maxLength(255)->required(),
                    TextInput::make('kind')->maxLength(255)->required(),
                    DatePicker::make('expires_on'),
                    TextInput::make('file_path')->maxLength(255)
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('kind')->searchable()->sortable()->toggleable(),
                TextColumn::make('expires_on')->sortable()->toggleable(),
                TextColumn::make('file_path')->searchable()->sortable()->toggleable()
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
        return ['name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->name ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => ComplianceDocumentResource\Pages\ListRecords::route('/'),
            'create' => ComplianceDocumentResource\Pages\CreateRecord::route('/create'),
            'edit' => ComplianceDocumentResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
