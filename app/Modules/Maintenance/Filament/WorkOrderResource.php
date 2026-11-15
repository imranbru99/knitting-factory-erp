<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament;

use App\Modules\Maintenance\Models\WorkOrder;
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

class WorkOrderResource extends Resource
{
    protected static ?string $model = WorkOrder::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Maintenance';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'number';

    public static function moduleKey(): string
    {
        return 'maintenance';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('WorkOrder')->columns(2)->schema([
                    Select::make('asset_id')->label('Asset Id')->relationship('asset', 'name')->nullable()->searchable()->preload(),
                    Select::make('machine_id')->label('Machine Id')->relationship('machine', 'code')->nullable()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    Select::make('kind')->options(['pm' => 'Pm', 'breakdown' => 'Breakdown'])->required(),
                    Select::make('priority')->options(['low' => 'Low', 'normal' => 'Normal', 'high' => 'High', 'critical' => 'Critical'])->nullable(),
                    Select::make('status')->options(['open' => 'Open', 'in_progress' => 'In Progress', 'closed' => 'Closed'])->nullable(),
                    DateTimePicker::make('opened_at'),
                    DateTimePicker::make('closed_at'),
                    TextInput::make('cost')->numeric(),
                    TextInput::make('downtime_minutes')->numeric(),
                    Textarea::make('description')->rows(3)->columnSpanFull()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset.name')->label('Asset Id')->toggleable(),
                TextColumn::make('machine.code')->label('Machine Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('kind')->searchable()->sortable()->toggleable(),
                TextColumn::make('priority')->searchable()->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable(),
                TextColumn::make('opened_at')->sortable()->toggleable(),
                TextColumn::make('closed_at')->sortable()->toggleable()
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
            'index' => WorkOrderResource\Pages\ListRecords::route('/'),
            'create' => WorkOrderResource\Pages\CreateRecord::route('/create'),
            'edit' => WorkOrderResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
