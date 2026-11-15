<?php

declare(strict_types=1);

namespace App\Modules\Quality\Filament;

use App\Modules\Quality\Models\Capa;
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

class CapaResource extends Resource
{
    protected static ?string $model = Capa::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Quality';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'number';

    public static function moduleKey(): string
    {
        return 'quality';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Capa')->columns(2)->schema([
                    Select::make('owner_id')->label('Owner Id')->relationship('owner', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('number')->maxLength(255),
                    TextInput::make('source')->maxLength(255),
                    DatePicker::make('due_on'),
                    Textarea::make('root_cause')->rows(3)->columnSpanFull(),
                    Textarea::make('action')->rows(3)->columnSpanFull(),
                    Select::make('status')->options(['open' => 'Open', 'verified' => 'Verified', 'closed' => 'Closed'])->nullable()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('owner.name')->label('Owner Id')->toggleable(),
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('source')->searchable()->sortable()->toggleable(),
                TextColumn::make('due_on')->sortable()->toggleable(),
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
            'index' => CapaResource\Pages\ListRecords::route('/'),
            'create' => CapaResource\Pages\CreateRecord::route('/create'),
            'edit' => CapaResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
