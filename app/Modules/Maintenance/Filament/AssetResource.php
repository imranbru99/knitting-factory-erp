<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament;

use App\Modules\Maintenance\Models\Asset;
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

class AssetResource extends Resource
{
    protected static ?string $model = Asset::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Maintenance';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';

    public static function moduleKey(): string
    {
        return 'maintenance';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Asset')->columns(2)->schema([
                    Select::make('machine_id')->label('Machine Id')->relationship('machine', 'code')->nullable()->searchable()->preload(),
                    TextInput::make('code')->maxLength(255)->required(),
                    TextInput::make('name')->maxLength(255)->required(),
                    TextInput::make('category')->maxLength(255)->required(),
                    TextInput::make('cost')->numeric(),
                    DatePicker::make('installed_on'),
                    TextInput::make('life_years')->numeric()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('machine.code')->label('Machine Id')->toggleable(),
                TextColumn::make('code')->searchable()->sortable()->toggleable(),
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('category')->searchable()->sortable()->toggleable(),
                TextColumn::make('cost')->sortable()->toggleable(),
                TextColumn::make('installed_on')->sortable()->toggleable(),
                TextColumn::make('life_years')->sortable()->toggleable()
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
        return ['code', 'name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->name ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => AssetResource\Pages\ListRecords::route('/'),
            'create' => AssetResource\Pages\CreateRecord::route('/create'),
            'edit' => AssetResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
