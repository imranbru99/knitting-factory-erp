<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament;

use App\Modules\HumanResources\Models\AttendanceDay;
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

class AttendanceDayResource extends Resource
{
    protected static ?string $model = AttendanceDay::class;

    protected static string | \UnitEnum | null $navigationGroup = 'HR & Payroll';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'work_date';

    public static function moduleKey(): string
    {
        return 'humanresources';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('AttendanceDay')->columns(2)->schema([
                    Select::make('employee_id')->label('Employee Id')->relationship('employee', 'name')->required()->searchable()->preload(),
                    DatePicker::make('work_date'),
                    Select::make('status')->options(['present' => 'Present', 'absent' => 'Absent', 'late' => 'Late', 'leave' => 'Leave', 'holiday' => 'Holiday'])->nullable(),
                    DateTimePicker::make('in_at'),
                    DateTimePicker::make('out_at'),
                    TextInput::make('ot_minutes')->numeric(),
                    TextInput::make('source')->maxLength(255)
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')->label('Employee Id')->toggleable(),
                TextColumn::make('work_date')->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable(),
                TextColumn::make('in_at')->sortable()->toggleable(),
                TextColumn::make('out_at')->sortable()->toggleable(),
                TextColumn::make('ot_minutes')->sortable()->toggleable(),
                TextColumn::make('source')->searchable()->sortable()->toggleable()
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
        return ['work_date'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->work_date ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => AttendanceDayResource\Pages\ListRecords::route('/'),
            'create' => AttendanceDayResource\Pages\CreateRecord::route('/create'),
            'edit' => AttendanceDayResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
