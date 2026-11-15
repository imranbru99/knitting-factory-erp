<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament;

use App\Modules\Operations\Models\IssueRule;
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

class IssueRuleResource extends Resource
{
    protected static ?string $model = IssueRule::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Issues & Tasks';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'key';

    public static function moduleKey(): string
    {
        return 'operations';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('IssueRule')->columns(2)->schema([
                    TextInput::make('key')->maxLength(255)->required(),
                    Toggle::make('enabled'),
                    TextInput::make('owner_role')->maxLength(255),
                    TextInput::make('severity')->maxLength(255),
                    TextInput::make('sla_hours')->numeric()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')->searchable()->sortable()->toggleable(),
                IconColumn::make('enabled')->boolean()->toggleable(),
                TextColumn::make('owner_role')->searchable()->sortable()->toggleable(),
                TextColumn::make('severity')->searchable()->sortable()->toggleable(),
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
        return ['key'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->key ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => IssueRuleResource\Pages\ListRecords::route('/'),
            'create' => IssueRuleResource\Pages\CreateRecord::route('/create'),
            'edit' => IssueRuleResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
