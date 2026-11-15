<?php

declare(strict_types=1);

namespace App\Modules\Quality\Filament;

use App\Modules\Quality\Models\BuyerClaim;
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

class BuyerClaimResource extends Resource
{
    protected static ?string $model = BuyerClaim::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Quality';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'number';

    public static function moduleKey(): string
    {
        return 'quality';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('BuyerClaim')->columns(2)->schema([
                    Select::make('party_id')->label('Party Id')->relationship('party', 'name')->required()->searchable()->preload(),
                    Select::make('sales_order_id')->label('Sales Order Id')->relationship('sales_order', 'number')->nullable()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('amount')->numeric(),
                    Select::make('status')->options(['open' => 'Open', 'accepted' => 'Accepted', 'rejected' => 'Rejected', 'recovered' => 'Recovered'])->nullable(),
                    Textarea::make('root_cause')->rows(3)->columnSpanFull()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('party.name')->label('Party Id')->toggleable(),
                TextColumn::make('sales_order.number')->label('Sales Order Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('amount')->sortable()->toggleable(),
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
            'index' => BuyerClaimResource\Pages\ListRecords::route('/'),
            'create' => BuyerClaimResource\Pages\CreateRecord::route('/create'),
            'edit' => BuyerClaimResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
