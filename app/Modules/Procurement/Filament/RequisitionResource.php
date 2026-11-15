<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament;

use App\Modules\Procurement\Models\Requisition;
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

class RequisitionResource extends Resource
{
    protected static ?string $model = Requisition::class;

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
            Section::make('Requisition')->columns(2)->schema([
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('source')->maxLength(255),
                    DatePicker::make('needed_on'),
                    Select::make('status')->options(['draft' => 'Draft', 'submitted' => 'Submitted', 'approved' => 'Approved', 'rejected' => 'Rejected', 'ordered' => 'Ordered'])->nullable(),
                    Textarea::make('notes')->rows(3)->columnSpanFull(),
                    Repeater::make('lines')->relationship()->schema([
                        Select::make('yarn_item_id')->label('Yarn Item Id')->relationship('yarn_item', 'name')->nullable()->searchable()->preload(),
                        TextInput::make('qty')->numeric(),
                        TextInput::make('uom')->maxLength(255)
                    ])->columnSpanFull()->collapsible()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('source')->searchable()->sortable()->toggleable(),
                TextColumn::make('needed_on')->sortable()->toggleable(),
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
            'index' => RequisitionResource\Pages\ListRecords::route('/'),
            'create' => RequisitionResource\Pages\CreateRecord::route('/create'),
            'edit' => RequisitionResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
