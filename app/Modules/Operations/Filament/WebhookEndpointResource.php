<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament;

use App\Modules\Operations\Models\WebhookEndpoint;
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

class WebhookEndpointResource extends Resource
{
    protected static ?string $model = WebhookEndpoint::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Issues & Tasks';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'event';

    public static function moduleKey(): string
    {
        return 'operations';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('WebhookEndpoint')->columns(2)->schema([
                    TextInput::make('url')->maxLength(255)->required(),
                    TextInput::make('event')->maxLength(255)->required(),
                    TextInput::make('secret')->maxLength(255),
                    Toggle::make('is_active')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('url')->searchable()->sortable()->toggleable(),
                TextColumn::make('event')->searchable()->sortable()->toggleable(),
                TextColumn::make('secret')->searchable()->sortable()->toggleable(),
                IconColumn::make('is_active')->boolean()->toggleable()
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
        return ['event'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->event ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => WebhookEndpointResource\Pages\ListRecords::route('/'),
            'create' => WebhookEndpointResource\Pages\CreateRecord::route('/create'),
            'edit' => WebhookEndpointResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
