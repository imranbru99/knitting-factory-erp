<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament;

use App\Modules\Procurement\Models\Rfq;
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

class RfqResource extends Resource
{
    protected static ?string $model = Rfq::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Procurement';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'number';

    public static function moduleKey(): string
    {
        return 'procurement';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Rfq')->columns(2)->schema([
                    Select::make('requisition_id')->label('Requisition Id')->relationship('requisition', 'number')->nullable()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    Select::make('status')->options(['draft' => 'Draft', 'sent' => 'Sent', 'compared' => 'Compared', 'awarded' => 'Awarded'])->nullable(),
                    DatePicker::make('due_on'),
                    Repeater::make('lines')->relationship()->schema([
                        Select::make('yarn_item_id')->label('Yarn Item Id')->relationship('yarn_item', 'name')->nullable()->searchable()->preload(),
                        TextInput::make('qty')->numeric()
                    ])->columnSpanFull()->collapsible()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('requisition.number')->label('Requisition Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable(),
                TextColumn::make('due_on')->sortable()->toggleable()
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
            'index' => RfqResource\Pages\ListRecords::route('/'),
            'create' => RfqResource\Pages\CreateRecord::route('/create'),
            'edit' => RfqResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
