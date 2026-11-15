<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament;

use App\Modules\Accounts\Models\Journal;
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

class JournalResource extends Resource
{
    protected static ?string $model = Journal::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Accounts';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'number';

    public static function moduleKey(): string
    {
        return 'accounts';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Journal')->columns(2)->schema([
                    TextInput::make('number')->maxLength(255),
                    DatePicker::make('journal_date'),
                    TextInput::make('source_type')->maxLength(255),
                    TextInput::make('source_id')->numeric(),
                    Textarea::make('narration')->rows(3)->columnSpanFull(),
                    Select::make('status')->options(['draft' => 'Draft', 'posted' => 'Posted'])->nullable(),
                    Repeater::make('lines')->relationship()->schema([
                        Select::make('account_id')->label('Account Id')->relationship('account', 'name')->required()->searchable()->preload(),
                        Select::make('cost_center_id')->label('Cost Center Id')->relationship('cost_center', 'name')->nullable()->searchable()->preload(),
                        Select::make('party_id')->label('Party Id')->relationship('party', 'name')->nullable()->searchable()->preload(),
                        TextInput::make('debit')->numeric(),
                        TextInput::make('credit')->numeric(),
                        TextInput::make('currency_code')->maxLength(255)
                    ])->columnSpanFull()->collapsible()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('journal_date')->sortable()->toggleable(),
                TextColumn::make('source_type')->searchable()->sortable()->toggleable(),
                TextColumn::make('source_id')->sortable()->toggleable(),
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
        return ['number'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->number ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => JournalResource\Pages\ListRecords::route('/'),
            'create' => JournalResource\Pages\CreateRecord::route('/create'),
            'edit' => JournalResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
