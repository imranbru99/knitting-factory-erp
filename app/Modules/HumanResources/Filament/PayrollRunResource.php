<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament;

use App\Modules\HumanResources\Models\PayrollRun;
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

class PayrollRunResource extends Resource
{
    protected static ?string $model = PayrollRun::class;

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
            Section::make('PayrollRun')->columns(2)->schema([
                    TextInput::make('year')->numeric()->required(),
                    TextInput::make('month')->numeric()->required(),
                    Select::make('status')->options(['draft' => 'Draft', 'approved' => 'Approved', 'posted' => 'Posted'])->nullable()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year')->sortable()->toggleable(),
                TextColumn::make('month')->sortable()->toggleable(),
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
            'index' => PayrollRunResource\Pages\ListRecords::route('/'),
            'create' => PayrollRunResource\Pages\CreateRecord::route('/create'),
            'edit' => PayrollRunResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
