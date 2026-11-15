<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament;

use App\Modules\Knitting\Models\MachineStoppage;
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

class MachineStoppageResource extends Resource
{
    protected static ?string $model = MachineStoppage::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Knitting';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'reason';

    public static function moduleKey(): string
    {
        return 'knitting';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('MachineStoppage')->columns(2)->schema([
                    Select::make('machine_id')->label('Machine Id')->relationship('machine', 'code')->required()->searchable()->preload(),
                    Select::make('operator_id')->label('Operator Id')->relationship('operator', 'name')->nullable()->searchable()->preload(),
                    Select::make('reason')->options(['yarn_break' => 'Yarn Break', 'needle_break' => 'Needle Break', 'lycra_break' => 'Lycra Break', 'power' => 'Power', 'no_yarn' => 'No Yarn', 'no_operator' => 'No Operator', 'mechanical' => 'Mechanical', 'electrical' => 'Electrical', 'program_change' => 'Program Change', 'cleaning' => 'Cleaning', 'lunch' => 'Lunch'])->required(),
                    DateTimePicker::make('started_at'),
                    DateTimePicker::make('ended_at'),
                    TextInput::make('minutes')->numeric()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('machine.code')->label('Machine Id')->toggleable(),
                TextColumn::make('operator.name')->label('Operator Id')->toggleable(),
                TextColumn::make('reason')->searchable()->sortable()->toggleable(),
                TextColumn::make('started_at')->sortable()->toggleable(),
                TextColumn::make('ended_at')->sortable()->toggleable(),
                TextColumn::make('minutes')->sortable()->toggleable()
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
        return ['reason'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->reason ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => MachineStoppageResource\Pages\ListRecords::route('/'),
            'create' => MachineStoppageResource\Pages\CreateRecord::route('/create'),
            'edit' => MachineStoppageResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
