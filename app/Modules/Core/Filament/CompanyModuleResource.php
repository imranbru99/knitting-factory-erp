<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament;

use App\Modules\Core\Models\CompanyModule;
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

class CompanyModuleResource extends Resource
{
    protected static ?string $model = CompanyModule::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Company';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'module_key';

    public static function moduleKey(): string
    {
        return 'core';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('CompanyModule')->columns(2)->schema([
                    TextInput::make('module_key')->maxLength(255)->required(),
                    Toggle::make('enabled')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('module_key')->searchable()->sortable()->toggleable(),
                IconColumn::make('enabled')->boolean()->toggleable()
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
        return ['module_key'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->module_key ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => CompanyModuleResource\Pages\ListRecords::route('/'),
            'create' => CompanyModuleResource\Pages\CreateRecord::route('/create'),
            'edit' => CompanyModuleResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
