<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament;

use App\Modules\Operations\Models\Issue;
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

class IssueResource extends Resource
{
    protected static ?string $model = Issue::class;

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
            Section::make('Issue')->columns(2)->schema([
                    TextInput::make('rule_key')->maxLength(255)->required(),
                    Select::make('severity')->options(['info' => 'Info', 'low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'critical' => 'Critical'])->required(),
                    TextInput::make('title')->maxLength(255)->required(),
                    Textarea::make('detail')->rows(3)->columnSpanFull(),
                    Textarea::make('suggested_solution')->rows(3)->columnSpanFull(),
                    TextInput::make('owner_role')->maxLength(255),
                    Select::make('status')->options(['open' => 'Open', 'snoozed' => 'Snoozed', 'justified' => 'Justified', 'resolved' => 'Resolved', 'escalated' => 'Escalated'])->nullable(),
                    DateTimePicker::make('sla_due_at'),
                    TextInput::make('subject_type')->maxLength(255),
                    TextInput::make('subject_id')->numeric(),
                    TextInput::make('escalated_level')->numeric(),
                    Textarea::make('snooze_reason')->rows(3)->columnSpanFull()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rule_key')->searchable()->sortable()->toggleable(),
                TextColumn::make('severity')->searchable()->sortable()->toggleable(),
                TextColumn::make('title')->searchable()->sortable()->toggleable(),
                TextColumn::make('owner_role')->searchable()->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable(),
                TextColumn::make('sla_due_at')->sortable()->toggleable(),
                TextColumn::make('subject_type')->searchable()->sortable()->toggleable(),
                TextColumn::make('subject_id')->sortable()->toggleable()
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
        return ['title', 'rule_key'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->title ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => IssueResource\Pages\ListRecords::route('/'),
            'create' => IssueResource\Pages\CreateRecord::route('/create'),
            'edit' => IssueResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
