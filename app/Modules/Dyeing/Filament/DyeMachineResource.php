<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament;

use App\Modules\Dyeing\Models\DyeMachine;
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

class DyeMachineResource extends Resource
{
    protected static ?string $model = DyeMachine::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Dyeing';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'code';

    public static function moduleKey(): string
    {
        return 'dyeing';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('DyeMachine')->columns(2)->schema([
                    TextInput::make('code')->maxLength(255)->required(),
                    TextInput::make('brand')->maxLength(255),
                    TextInput::make('capacity_kg')->numeric(),
                    Select::make('status')->options(['idle' => 'Idle', 'running' => 'Running', 'down' => 'Down'])->nullable()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->searchable()->sortable()->toggleable(),
                TextColumn::make('brand')->searchable()->sortable()->toggleable(),
                TextColumn::make('capacity_kg')->sortable()->toggleable(),
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
        return ['code'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->code ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => DyeMachineResource\Pages\ListRecords::route('/'),
            'create' => DyeMachineResource\Pages\CreateRecord::route('/create'),
            'edit' => DyeMachineResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
