<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament;

use App\Modules\Procurement\Models\RfqQuote;
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

class RfqQuoteResource extends Resource
{
    protected static ?string $model = RfqQuote::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Procurement';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'id';

    public static function moduleKey(): string
    {
        return 'procurement';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('RfqQuote')->columns(2)->schema([
                    Select::make('rfq_id')->label('Rfq Id')->relationship('rfq', 'number')->required()->searchable()->preload(),
                    Select::make('party_id')->label('Party Id')->relationship('party', 'name')->required()->searchable()->preload(),
                    Select::make('yarn_item_id')->label('Yarn Item Id')->relationship('yarn_item', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('rate')->numeric(),
                    TextInput::make('lead_days')->numeric(),
                    TextInput::make('score')->numeric()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rfq.number')->label('Rfq Id')->toggleable(),
                TextColumn::make('party.name')->label('Party Id')->toggleable(),
                TextColumn::make('yarn_item.name')->label('Yarn Item Id')->toggleable(),
                TextColumn::make('rate')->sortable()->toggleable(),
                TextColumn::make('lead_days')->sortable()->toggleable(),
                TextColumn::make('score')->sortable()->toggleable()
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
            'index' => RfqQuoteResource\Pages\ListRecords::route('/'),
            'create' => RfqQuoteResource\Pages\CreateRecord::route('/create'),
            'edit' => RfqQuoteResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
