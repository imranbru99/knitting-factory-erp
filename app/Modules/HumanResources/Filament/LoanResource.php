<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament;

use App\Modules\HumanResources\Models\Loan;
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

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

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
            Section::make('Loan')->columns(2)->schema([
                    Select::make('employee_id')->label('Employee Id')->relationship('employee', 'name')->required()->searchable()->preload(),
                    TextInput::make('principal')->numeric(),
                    TextInput::make('balance')->numeric(),
                    TextInput::make('installment')->numeric(),
                    TextInput::make('status')->maxLength(255)
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')->label('Employee Id')->toggleable(),
                TextColumn::make('principal')->sortable()->toggleable(),
                TextColumn::make('balance')->sortable()->toggleable(),
                TextColumn::make('installment')->sortable()->toggleable(),
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
            'index' => LoanResource\Pages\ListRecords::route('/'),
            'create' => LoanResource\Pages\CreateRecord::route('/create'),
            'edit' => LoanResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
