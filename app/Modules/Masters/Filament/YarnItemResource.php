<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament;

use App\Modules\Masters\Models\YarnItem;
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

class YarnItemResource extends Resource
{
    protected static ?string $model = YarnItem::class;

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
            Section::make('YarnItem')->columns(2)->schema([
                    Select::make('yarn_count_id')->label('Yarn Count Id')->relationship('yarn_count', 'label')->nullable()->searchable()->preload(),
                    Select::make('yarn_type_id')->label('Yarn Type Id')->relationship('yarn_type', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('code')->maxLength(255)->required(),
                    TextInput::make('name')->maxLength(255)->required(),
                    TextInput::make('brand')->maxLength(255),
                    TextInput::make('composition')->maxLength(255),
                    TextInput::make('ply')->maxLength(255),
                    TextInput::make('twist')->maxLength(255),
                    TextInput::make('uom')->maxLength(255),
                    TextInput::make('reorder_level')->numeric(),
                    TextInput::make('min_qty')->numeric(),
                    TextInput::make('max_qty')->numeric(),
                    TextInput::make('lead_time_days')->numeric(),
                    TextInput::make('last_rate')->numeric()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('yarn_count.label')->label('Yarn Count Id')->toggleable(),
                TextColumn::make('yarn_type.name')->label('Yarn Type Id')->toggleable(),
                TextColumn::make('code')->searchable()->sortable()->toggleable(),
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('brand')->searchable()->sortable()->toggleable(),
                TextColumn::make('composition')->searchable()->sortable()->toggleable(),
                TextColumn::make('ply')->searchable()->sortable()->toggleable(),
                TextColumn::make('twist')->searchable()->sortable()->toggleable()
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
        return ['code', 'name', 'brand'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->name ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => YarnItemResource\Pages\ListRecords::route('/'),
            'create' => YarnItemResource\Pages\CreateRecord::route('/create'),
            'edit' => YarnItemResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
