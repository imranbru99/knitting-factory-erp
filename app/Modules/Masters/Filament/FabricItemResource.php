<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament;

use App\Modules\Masters\Models\FabricItem;
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

class FabricItemResource extends Resource
{
    protected static ?string $model = FabricItem::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Masters';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';

    public static function moduleKey(): string
    {
        return 'masters';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('FabricItem')->columns(2)->schema([
                    Select::make('fabric_construction_id')->label('Fabric Construction Id')->relationship('fabric_construction', 'name')->nullable()->searchable()->preload(),
                    Select::make('color_id')->label('Color Id')->relationship('color', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('code')->maxLength(255)->required(),
                    TextInput::make('name')->maxLength(255)->required(),
                    TextInput::make('gsm_target')->numeric(),
                    TextInput::make('gsm_min')->numeric(),
                    TextInput::make('gsm_max')->numeric(),
                    TextInput::make('dia')->numeric(),
                    TextInput::make('composition')->maxLength(255),
                    TextInput::make('gauge')->numeric(),
                    TextInput::make('stitch_length')->numeric(),
                    TextInput::make('uom')->maxLength(255)
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fabric_construction.name')->label('Fabric Construction Id')->toggleable(),
                TextColumn::make('color.name')->label('Color Id')->toggleable(),
                TextColumn::make('code')->searchable()->sortable()->toggleable(),
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('gsm_target')->sortable()->toggleable(),
                TextColumn::make('gsm_min')->sortable()->toggleable(),
                TextColumn::make('gsm_max')->sortable()->toggleable(),
                TextColumn::make('dia')->sortable()->toggleable()
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
        return ['code', 'name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->name ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => FabricItemResource\Pages\ListRecords::route('/'),
            'create' => FabricItemResource\Pages\CreateRecord::route('/create'),
            'edit' => FabricItemResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
