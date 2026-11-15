<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament;

use App\Modules\Commercial\Models\OrderMilestone;
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

class OrderMilestoneResource extends Resource
{
    protected static ?string $model = OrderMilestone::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Merchandising';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';

    public static function moduleKey(): string
    {
        return 'commercial';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('OrderMilestone')->columns(2)->schema([
                    Select::make('sales_order_id')->label('Sales Order Id')->relationship('sales_order', 'number')->required()->searchable()->preload(),
                    TextInput::make('name')->maxLength(255)->required(),
                    DatePicker::make('planned_on'),
                    DatePicker::make('actual_on'),
                    Select::make('status')->options(['pending' => 'Pending', 'done' => 'Done', 'late' => 'Late'])->nullable()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sales_order.number')->label('Sales Order Id')->toggleable(),
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('planned_on')->sortable()->toggleable(),
                TextColumn::make('actual_on')->sortable()->toggleable(),
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
        return ['name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->name ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => OrderMilestoneResource\Pages\ListRecords::route('/'),
            'create' => OrderMilestoneResource\Pages\CreateRecord::route('/create'),
            'edit' => OrderMilestoneResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
