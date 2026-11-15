<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament;

use App\Modules\Commercial\Models\Inquiry;
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

class InquiryResource extends Resource
{
    protected static ?string $model = Inquiry::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Merchandising';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'number';

    public static function moduleKey(): string
    {
        return 'commercial';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Inquiry')->columns(2)->schema([
                    Select::make('party_id')->label('Party Id')->relationship('party', 'name')->nullable()->searchable()->preload(),
                    Select::make('fabric_item_id')->label('Fabric Item Id')->relationship('fabric_item', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('subject')->maxLength(255)->required(),
                    TextInput::make('qty_kg')->numeric(),
                    DatePicker::make('target_date'),
                    Select::make('status')->options(['open' => 'Open', 'quoted' => 'Quoted', 'won' => 'Won', 'lost' => 'Lost'])->nullable(),
                    TextInput::make('source')->maxLength(255),
                    Textarea::make('notes')->rows(3)->columnSpanFull()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('party.name')->label('Party Id')->toggleable(),
                TextColumn::make('fabric_item.name')->label('Fabric Item Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('subject')->searchable()->sortable()->toggleable(),
                TextColumn::make('qty_kg')->sortable()->toggleable(),
                TextColumn::make('target_date')->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable(),
                TextColumn::make('source')->searchable()->sortable()->toggleable()
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
        return ['number', 'subject'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->number ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => InquiryResource\Pages\ListRecords::route('/'),
            'create' => InquiryResource\Pages\CreateRecord::route('/create'),
            'edit' => InquiryResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
