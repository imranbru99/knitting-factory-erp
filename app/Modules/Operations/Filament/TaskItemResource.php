<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament;

use App\Modules\Operations\Models\TaskItem;
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

class TaskItemResource extends Resource
{
    protected static ?string $model = TaskItem::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Issues & Tasks';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'title';

    public static function moduleKey(): string
    {
        return 'operations';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('TaskItem')->columns(2)->schema([
                    TextInput::make('title')->maxLength(255)->required(),
                    TextInput::make('from_department')->maxLength(255),
                    TextInput::make('to_department')->maxLength(255),
                    Select::make('status')->options(['open' => 'Open', 'done' => 'Done', 'overdue' => 'Overdue'])->nullable(),
                    DateTimePicker::make('due_at'),
                    TextInput::make('sla_hours')->numeric(),
                    Textarea::make('detail')->rows(3)->columnSpanFull()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable()->toggleable(),
                TextColumn::make('from_department')->searchable()->sortable()->toggleable(),
                TextColumn::make('to_department')->searchable()->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable(),
                TextColumn::make('due_at')->sortable()->toggleable(),
                TextColumn::make('sla_hours')->sortable()->toggleable()
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
        return ['title'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->title ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => TaskItemResource\Pages\ListRecords::route('/'),
            'create' => TaskItemResource\Pages\CreateRecord::route('/create'),
            'edit' => TaskItemResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
