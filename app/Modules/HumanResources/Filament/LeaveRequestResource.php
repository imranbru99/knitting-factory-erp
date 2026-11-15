<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament;

use App\Modules\HumanResources\Models\LeaveRequest;
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

class LeaveRequestResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;

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
            Section::make('LeaveRequest')->columns(2)->schema([
                    Select::make('employee_id')->label('Employee Id')->relationship('employee', 'name')->required()->searchable()->preload(),
                    Select::make('leave_type_id')->label('Leave Type Id')->relationship('leave_type', 'name')->nullable()->searchable()->preload(),
                    DatePicker::make('starts_on'),
                    DatePicker::make('ends_on'),
                    Select::make('status')->options(['draft' => 'Draft', 'approved' => 'Approved', 'rejected' => 'Rejected'])->nullable(),
                    Textarea::make('reason')->rows(3)->columnSpanFull()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')->label('Employee Id')->toggleable(),
                TextColumn::make('leave_type.name')->label('Leave Type Id')->toggleable(),
                TextColumn::make('starts_on')->sortable()->toggleable(),
                TextColumn::make('ends_on')->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable()
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
            'index' => LeaveRequestResource\Pages\ListRecords::route('/'),
            'create' => LeaveRequestResource\Pages\CreateRecord::route('/create'),
            'edit' => LeaveRequestResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
