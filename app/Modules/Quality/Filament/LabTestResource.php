<?php

declare(strict_types=1);

namespace App\Modules\Quality\Filament;

use App\Modules\Quality\Models\LabTest;
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

class LabTestResource extends Resource
{
    protected static ?string $model = LabTest::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Quality';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'test_name';

    public static function moduleKey(): string
    {
        return 'quality';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('LabTest')->columns(2)->schema([
                    Select::make('roll_id')->label('Roll Id')->relationship('roll', 'number')->nullable()->searchable()->preload(),
                    Select::make('dye_batch_id')->label('Dye Batch Id')->relationship('dye_batch', 'number')->nullable()->searchable()->preload(),
                    TextInput::make('test_name')->maxLength(255)->required(),
                    TextInput::make('standard')->maxLength(255),
                    TextInput::make('result_value')->maxLength(255),
                    TextInput::make('unit')->maxLength(255),
                    Toggle::make('passed')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('roll.number')->label('Roll Id')->toggleable(),
                TextColumn::make('dye_batch.number')->label('Dye Batch Id')->toggleable(),
                TextColumn::make('test_name')->searchable()->sortable()->toggleable(),
                TextColumn::make('standard')->searchable()->sortable()->toggleable(),
                TextColumn::make('result_value')->searchable()->sortable()->toggleable(),
                TextColumn::make('unit')->searchable()->sortable()->toggleable(),
                IconColumn::make('passed')->boolean()->toggleable()
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
        return ['test_name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->test_name ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => LabTestResource\Pages\ListRecords::route('/'),
            'create' => LabTestResource\Pages\CreateRecord::route('/create'),
            'edit' => LabTestResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
