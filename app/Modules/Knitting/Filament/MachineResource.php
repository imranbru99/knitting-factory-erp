<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament;

use App\Modules\Knitting\Models\Machine;
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

class MachineResource extends Resource
{
    protected static ?string $model = Machine::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Knitting';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'code';

    public static function moduleKey(): string
    {
        return 'knitting';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Machine')->columns(2)->schema([
                    Select::make('unit_id')->label('Unit Id')->relationship('unit', 'name')->nullable()->searchable()->preload(),
                    Select::make('floor_id')->label('Floor Id')->relationship('floor', 'name')->nullable()->searchable()->preload(),
                    Select::make('machine_brand_id')->label('Machine Brand Id')->relationship('machine_brand', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('code')->maxLength(255)->required(),
                    TextInput::make('name')->maxLength(255)->required(),
                    Select::make('machine_type')->options(['single_jersey' => 'Single Jersey', 'double_jersey' => 'Double Jersey', 'rib' => 'Rib', 'fleece' => 'Fleece', 'jacquard' => 'Jacquard', 'terry' => 'Terry', 'flat' => 'Flat', 'collar' => 'Collar'])->required(),
                    TextInput::make('dia')->numeric(),
                    TextInput::make('gauge')->numeric(),
                    TextInput::make('feeders')->numeric(),
                    TextInput::make('rpm')->numeric(),
                    TextInput::make('capacity_kg_shift')->numeric(),
                    Select::make('status')->options(['idle' => 'Idle', 'running' => 'Running', 'setup' => 'Setup', 'down' => 'Down'])->nullable(),
                    DatePicker::make('installed_on')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unit.name')->label('Unit Id')->toggleable(),
                TextColumn::make('floor.name')->label('Floor Id')->toggleable(),
                TextColumn::make('machine_brand.name')->label('Machine Brand Id')->toggleable(),
                TextColumn::make('code')->searchable()->sortable()->toggleable(),
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('machine_type')->searchable()->sortable()->toggleable(),
                TextColumn::make('dia')->sortable()->toggleable(),
                TextColumn::make('gauge')->sortable()->toggleable()
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
        return (string) ($record->code ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => MachineResource\Pages\ListRecords::route('/'),
            'create' => MachineResource\Pages\CreateRecord::route('/create'),
            'edit' => MachineResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
