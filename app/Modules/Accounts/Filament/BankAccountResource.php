<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament;

use App\Modules\Accounts\Models\BankAccount;
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

class BankAccountResource extends Resource
{
    protected static ?string $model = BankAccount::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Accounts';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';

    public static function moduleKey(): string
    {
        return 'accounts';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('BankAccount')->columns(2)->schema([
                    Select::make('gl_account_id')->label('Gl Account Id')->relationship('glAccount', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('name')->maxLength(255)->required(),
                    TextInput::make('account_no')->maxLength(255)
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('glAccount.name')->label('Gl Account Id')->toggleable(),
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('account_no')->searchable()->sortable()->toggleable()
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
        return ['name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->name ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => BankAccountResource\Pages\ListRecords::route('/'),
            'create' => BankAccountResource\Pages\CreateRecord::route('/create'),
            'edit' => BankAccountResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
