<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament;

use App\Modules\HumanResources\Models\Payslip;
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

class PayslipResource extends Resource
{
    protected static ?string $model = Payslip::class;

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
            Section::make('Payslip')->columns(2)->schema([
                    Select::make('payroll_run_id')->label('Payroll Run Id')->relationship('payroll_run', 'id')->required()->searchable()->preload(),
                    Select::make('employee_id')->label('Employee Id')->relationship('employee', 'name')->required()->searchable()->preload(),
                    TextInput::make('gross')->numeric(),
                    TextInput::make('deductions')->numeric(),
                    TextInput::make('net')->numeric(),
                    Repeater::make('lines')->relationship()->schema([
                        TextInput::make('kind')->maxLength(255)->required(),
                        TextInput::make('amount')->numeric()
                    ])->columnSpanFull()->collapsible()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payroll_run.id')->label('Payroll Run Id')->toggleable(),
                TextColumn::make('employee.name')->label('Employee Id')->toggleable(),
                TextColumn::make('gross')->sortable()->toggleable(),
                TextColumn::make('deductions')->sortable()->toggleable(),
                TextColumn::make('net')->sortable()->toggleable()
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
            'index' => PayslipResource\Pages\ListRecords::route('/'),
            'create' => PayslipResource\Pages\CreateRecord::route('/create'),
            'edit' => PayslipResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
