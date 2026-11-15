<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament;

use App\Modules\Knitting\Models\NeedleLog;
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

class NeedleLogResource extends Resource
{
    protected static ?string $model = NeedleLog::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Knitting';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'kind';

    public static function moduleKey(): string
    {
        return 'knitting';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('NeedleLog')->columns(2)->schema([
                    Select::make('machine_id')->label('Machine Id')->relationship('machine', 'code')->required()->searchable()->preload(),
                    TextInput::make('kind')->maxLength(255)->required(),
                    TextInput::make('qty')->numeric(),
                    DatePicker::make('changed_on'),
                    TextInput::make('reason')->maxLength(255)
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('machine.code')->label('Machine Id')->toggleable(),
                TextColumn::make('kind')->searchable()->sortable()->toggleable(),
                TextColumn::make('qty')->sortable()->toggleable(),
                TextColumn::make('changed_on')->sortable()->toggleable(),
                TextColumn::make('reason')->searchable()->sortable()->toggleable()
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
        return ['kind'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->kind ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => NeedleLogResource\Pages\ListRecords::route('/'),
            'create' => NeedleLogResource\Pages\CreateRecord::route('/create'),
            'edit' => NeedleLogResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
