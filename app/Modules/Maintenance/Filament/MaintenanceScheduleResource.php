<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament;

use App\Modules\Maintenance\Models\MaintenanceSchedule;
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

class MaintenanceScheduleResource extends Resource
{
    protected static ?string $model = MaintenanceSchedule::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Maintenance';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'id';

    public static function moduleKey(): string
    {
        return 'maintenance';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('MaintenanceSchedule')->columns(2)->schema([
                    Select::make('asset_id')->label('Asset Id')->relationship('asset', 'name')->required()->searchable()->preload(),
                    TextInput::make('every_hours')->numeric(),
                    TextInput::make('every_days')->numeric(),
                    DatePicker::make('last_done_on'),
                    DatePicker::make('next_due_on')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset.name')->label('Asset Id')->toggleable(),
                TextColumn::make('every_hours')->sortable()->toggleable(),
                TextColumn::make('every_days')->sortable()->toggleable(),
                TextColumn::make('last_done_on')->sortable()->toggleable(),
                TextColumn::make('next_due_on')->sortable()->toggleable()
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
        return [];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->id ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => MaintenanceScheduleResource\Pages\ListRecords::route('/'),
            'create' => MaintenanceScheduleResource\Pages\CreateRecord::route('/create'),
            'edit' => MaintenanceScheduleResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
