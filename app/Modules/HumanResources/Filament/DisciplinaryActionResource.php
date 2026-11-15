<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament;

use App\Modules\HumanResources\Models\DisciplinaryAction;
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

class DisciplinaryActionResource extends Resource
{
    protected static ?string $model = DisciplinaryAction::class;

    protected static string | \UnitEnum | null $navigationGroup = 'HR & Payroll';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'kind';

    public static function moduleKey(): string
    {
        return 'humanresources';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('DisciplinaryAction')->columns(2)->schema([
                    Select::make('employee_id')->label('Employee Id')->relationship('employee', 'name')->required()->searchable()->preload(),
                    Select::make('kind')->options(['warning' => 'Warning', 'show_cause' => 'Show Cause', 'suspension' => 'Suspension', 'termination' => 'Termination'])->required(),
                    Textarea::make('note')->rows(3)->columnSpanFull(),
                    DatePicker::make('issued_on')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')->label('Employee Id')->toggleable(),
                TextColumn::make('kind')->searchable()->sortable()->toggleable(),
                TextColumn::make('issued_on')->sortable()->toggleable()
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
        return ['kind'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->kind ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => DisciplinaryActionResource\Pages\ListRecords::route('/'),
            'create' => DisciplinaryActionResource\Pages\CreateRecord::route('/create'),
            'edit' => DisciplinaryActionResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
