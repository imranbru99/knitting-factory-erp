<?php

declare(strict_types=1);

namespace App\Modules\Waste\Filament;

use App\Modules\Waste\Models\WasteSale;
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

class WasteSaleResource extends Resource
{
    protected static ?string $model = WasteSale::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Waste';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'number';

    public static function moduleKey(): string
    {
        return 'waste';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('WasteSale')->columns(2)->schema([
                    Select::make('party_id')->label('Party Id')->relationship('party', 'name')->required()->searchable()->preload(),
                    Select::make('gate_pass_id')->label('Gate Pass Id')->relationship('gate_pass', 'number')->nullable()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('qty_kg')->numeric(),
                    TextInput::make('amount')->numeric(),
                    Select::make('status')->options(['draft' => 'Draft', 'approved' => 'Approved'])->nullable()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('party.name')->label('Party Id')->toggleable(),
                TextColumn::make('gate_pass.number')->label('Gate Pass Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('qty_kg')->sortable()->toggleable(),
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
            'index' => WasteSaleResource\Pages\ListRecords::route('/'),
            'create' => WasteSaleResource\Pages\CreateRecord::route('/create'),
            'edit' => WasteSaleResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
