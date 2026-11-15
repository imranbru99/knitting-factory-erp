<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament;

use App\Modules\Commercial\Models\CostSheet;
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

class CostSheetResource extends Resource
{
    protected static ?string $model = CostSheet::class;

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
            Section::make('CostSheet')->columns(2)->schema([
                    Select::make('party_id')->label('Party Id')->relationship('party', 'name')->nullable()->searchable()->preload(),
                    Select::make('fabric_item_id')->label('Fabric Item Id')->relationship('fabric_item', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('yarn_rate')->numeric(),
                    TextInput::make('knitting_charge')->numeric(),
                    TextInput::make('dyeing_charge')->numeric(),
                    TextInput::make('process_loss_pct')->numeric(),
                    TextInput::make('wastage_pct')->numeric(),
                    TextInput::make('overhead_pct')->numeric(),
                    TextInput::make('finance_pct')->numeric(),
                    TextInput::make('profit_pct')->numeric(),
                    TextInput::make('cost_per_kg')->numeric(),
                    TextInput::make('cost_per_yard')->numeric(),
                    TextInput::make('quoted_rate')->numeric(),
                    Select::make('status')->options(['draft' => 'Draft', 'approved' => 'Approved', 'rejected' => 'Rejected'])->nullable()
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
                TextColumn::make('yarn_rate')->sortable()->toggleable(),
                TextColumn::make('knitting_charge')->sortable()->toggleable(),
                TextColumn::make('dyeing_charge')->sortable()->toggleable(),
                TextColumn::make('process_loss_pct')->sortable()->toggleable(),
                TextColumn::make('wastage_pct')->sortable()->toggleable()
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
            'index' => CostSheetResource\Pages\ListRecords::route('/'),
            'create' => CostSheetResource\Pages\CreateRecord::route('/create'),
            'edit' => CostSheetResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
