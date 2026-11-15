<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament;

use App\Modules\Operations\Models\NotificationDispatch;
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

class NotificationDispatchResource extends Resource
{
    protected static ?string $model = NotificationDispatch::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Issues & Tasks';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'subject';

    public static function moduleKey(): string
    {
        return 'operations';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('NotificationDispatch')->columns(2)->schema([
                    TextInput::make('channel')->maxLength(255)->required(),
                    TextInput::make('recipient')->maxLength(255),
                    TextInput::make('subject')->maxLength(255),
                    Textarea::make('body')->rows(3)->columnSpanFull(),
                    Select::make('status')->options(['queued' => 'Queued', 'sent' => 'Sent', 'failed' => 'Failed'])->nullable()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('channel')->searchable()->sortable()->toggleable(),
                TextColumn::make('recipient')->searchable()->sortable()->toggleable(),
                TextColumn::make('subject')->searchable()->sortable()->toggleable(),
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
        return ['subject'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->subject ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => NotificationDispatchResource\Pages\ListRecords::route('/'),
            'create' => NotificationDispatchResource\Pages\CreateRecord::route('/create'),
            'edit' => NotificationDispatchResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
