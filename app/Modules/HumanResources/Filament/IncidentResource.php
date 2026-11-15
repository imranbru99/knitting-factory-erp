<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament;

use App\Modules\HumanResources\Models\Incident;
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

class IncidentResource extends Resource
{
    protected static ?string $model = Incident::class;

    protected static string | \UnitEnum | null $navigationGroup = 'HR & Payroll';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'id';

    public static function moduleKey(): string
    {
        return 'humanresources';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Incident')->columns(2)->schema([
                    Select::make('employee_id')->label('Employee Id')->relationship('employee', 'name')->nullable()->searchable()->preload(),
                    DatePicker::make('occurred_on'),
                    Select::make('severity')->options(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'])->nullable(),
                    Textarea::make('description')->rows(3)->columnSpanFull()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')->label('Employee Id')->toggleable(),
                TextColumn::make('occurred_on')->sortable()->toggleable(),
                TextColumn::make('severity')->searchable()->sortable()->toggleable()
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
            'index' => IncidentResource\Pages\ListRecords::route('/'),
            'create' => IncidentResource\Pages\CreateRecord::route('/create'),
            'edit' => IncidentResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
