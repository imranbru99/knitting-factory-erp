<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament;

use App\Modules\Accounts\Models\BankLine;
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

class BankLineResource extends Resource
{
    protected static ?string $model = BankLine::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Accounts';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'reference';

    public static function moduleKey(): string
    {
        return 'accounts';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('BankLine')->columns(2)->schema([
                    Select::make('bank_account_id')->label('Bank Account Id')->relationship('bank_account', 'name')->required()->searchable()->preload(),
                    DatePicker::make('txn_date'),
                    TextInput::make('amount')->numeric(),
                    TextInput::make('reference')->maxLength(255),
                    Toggle::make('matched')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bank_account.name')->label('Bank Account Id')->toggleable(),
                TextColumn::make('txn_date')->sortable()->toggleable(),
                TextColumn::make('amount')->sortable()->toggleable(),
                TextColumn::make('reference')->searchable()->sortable()->toggleable(),
                IconColumn::make('matched')->boolean()->toggleable()
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
        return ['reference'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->reference ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => BankLineResource\Pages\ListRecords::route('/'),
            'create' => BankLineResource\Pages\CreateRecord::route('/create'),
            'edit' => BankLineResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
