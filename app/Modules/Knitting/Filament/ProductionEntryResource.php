<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament;

use App\Modules\Knitting\Models\ProductionEntry;
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

class ProductionEntryResource extends Resource
{
    protected static ?string $model = ProductionEntry::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Knitting';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'id';

    public static function moduleKey(): string
    {
        return 'knitting';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('ProductionEntry')->columns(2)->schema([
                    Select::make('machine_id')->label('Machine Id')->relationship('machine', 'code')->required()->searchable()->preload(),
                    Select::make('shift_id')->label('Shift Id')->relationship('shift', 'name')->nullable()->searchable()->preload(),
                    Select::make('operator_id')->label('Operator Id')->relationship('operator', 'name')->nullable()->searchable()->preload(),
                    Select::make('knitting_program_id')->label('Knitting Program Id')->relationship('knitting_program', 'number')->nullable()->searchable()->preload(),
                    DateTimePicker::make('started_at'),
                    DateTimePicker::make('ended_at'),
                    TextInput::make('produced_kg')->numeric(),
                    TextInput::make('rpm_actual')->numeric(),
                    Textarea::make('note')->rows(3)->columnSpanFull()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('machine.code')->label('Machine Id')->toggleable(),
                TextColumn::make('shift.name')->label('Shift Id')->toggleable(),
                TextColumn::make('operator.name')->label('Operator Id')->toggleable(),
                TextColumn::make('knitting_program.number')->label('Knitting Program Id')->toggleable(),
                TextColumn::make('started_at')->sortable()->toggleable(),
                TextColumn::make('ended_at')->sortable()->toggleable(),
                TextColumn::make('produced_kg')->sortable()->toggleable(),
                TextColumn::make('rpm_actual')->sortable()->toggleable()
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
            'index' => ProductionEntryResource\Pages\ListRecords::route('/'),
            'create' => ProductionEntryResource\Pages\CreateRecord::route('/create'),
            'edit' => ProductionEntryResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
