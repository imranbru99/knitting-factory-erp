<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament;

use App\Modules\Core\Models\Permission;
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

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Company';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';

    public static function moduleKey(): string
    {
        return 'core';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Permission')->columns(2)->schema([
                    TextInput::make('name')->maxLength(255)->required(),
                    TextInput::make('module')->maxLength(255)->required(),
                    TextInput::make('description')->maxLength(255)
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('module')->searchable()->sortable()->toggleable(),
                TextColumn::make('description')->searchable()->sortable()->toggleable()
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
        return ['name', 'module'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->name ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => PermissionResource\Pages\ListRecords::route('/'),
            'create' => PermissionResource\Pages\CreateRecord::route('/create'),
            'edit' => PermissionResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
