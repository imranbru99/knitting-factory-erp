<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament;

use App\Modules\Commercial\Models\Quotation;
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

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;

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
            Section::make('Quotation')->columns(2)->schema([
                    Select::make('party_id')->label('Party Id')->relationship('party', 'name')->required()->searchable()->preload(),
                    Select::make('cost_sheet_id')->label('Cost Sheet Id')->relationship('cost_sheet', 'number')->nullable()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    Select::make('status')->options(['draft' => 'Draft', 'submitted' => 'Submitted', 'approved' => 'Approved', 'rejected' => 'Rejected', 'converted' => 'Converted'])->nullable(),
                    DatePicker::make('valid_until'),
                    TextInput::make('currency_code')->maxLength(255),
                    Textarea::make('notes')->rows(3)->columnSpanFull(),
                    Repeater::make('lines')->relationship()->schema([
                        Select::make('fabric_item_id')->label('Fabric Item Id')->relationship('fabric_item', 'name')->nullable()->searchable()->preload(),
                        Select::make('color_id')->label('Color Id')->relationship('color', 'name')->nullable()->searchable()->preload(),
                        TextInput::make('qty')->numeric(),
                        TextInput::make('rate')->numeric(),
                        TextInput::make('uom')->maxLength(255)
                    ])->columnSpanFull()->collapsible()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('party.name')->label('Party Id')->toggleable(),
                TextColumn::make('cost_sheet.number')->label('Cost Sheet Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable(),
                TextColumn::make('valid_until')->sortable()->toggleable(),
                TextColumn::make('currency_code')->searchable()->sortable()->toggleable()
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
            'index' => QuotationResource\Pages\ListRecords::route('/'),
            'create' => QuotationResource\Pages\CreateRecord::route('/create'),
            'edit' => QuotationResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
