<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament;

use App\Modules\Masters\Models\Employee;
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

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Masters';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';

    public static function moduleKey(): string
    {
        return 'masters';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Employee')->columns(2)->schema([
                    Select::make('department_id')->label('Department Id')->relationship('department', 'name')->nullable()->searchable()->preload(),
                    Select::make('shift_id')->label('Shift Id')->relationship('shift', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('code')->maxLength(255)->required(),
                    TextInput::make('name')->maxLength(255)->required(),
                    TextInput::make('name_bn')->maxLength(255),
                    TextInput::make('designation')->maxLength(255),
                    TextInput::make('grade')->maxLength(255),
                    Select::make('employment_type')->options(['permanent' => 'Permanent', 'contract' => 'Contract', 'piece_rate' => 'Piece Rate', 'daily' => 'Daily'])->nullable(),
                    TextInput::make('phone')->maxLength(255),
                    DatePicker::make('joining_date'),
                    TextInput::make('basic_salary')->numeric(),
                    Toggle::make('is_operator'),
                    TextInput::make('biometric_uid')->maxLength(255),
                    Select::make('status')->options(['active' => 'Active', 'left' => 'Left', 'suspended' => 'Suspended'])->nullable()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('department.name')->label('Department Id')->toggleable(),
                TextColumn::make('shift.name')->label('Shift Id')->toggleable(),
                TextColumn::make('code')->searchable()->sortable()->toggleable(),
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('name_bn')->searchable()->sortable()->toggleable(),
                TextColumn::make('designation')->searchable()->sortable()->toggleable(),
                TextColumn::make('grade')->searchable()->sortable()->toggleable(),
                TextColumn::make('employment_type')->searchable()->sortable()->toggleable()
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
            'index' => EmployeeResource\Pages\ListRecords::route('/'),
            'create' => EmployeeResource\Pages\CreateRecord::route('/create'),
            'edit' => EmployeeResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
