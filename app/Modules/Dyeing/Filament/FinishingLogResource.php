<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament;

use App\Modules\Dyeing\Models\FinishingLog;
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

class FinishingLogResource extends Resource
{
    protected static ?string $model = FinishingLog::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Dyeing';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'process';

    public static function moduleKey(): string
    {
        return 'dyeing';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('FinishingLog')->columns(2)->schema([
                    Select::make('dye_batch_id')->label('Dye Batch Id')->relationship('dye_batch', 'number')->required()->searchable()->preload(),
                    TextInput::make('process')->maxLength(255)->required(),
                    TextInput::make('machine_name')->maxLength(255),
                    TextInput::make('gsm_after')->numeric(),
                    TextInput::make('dia_after')->numeric(),
                    TextInput::make('shrinkage_l')->numeric(),
                    TextInput::make('shrinkage_w')->numeric(),
                    DateTimePicker::make('done_at')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('dye_batch.number')->label('Dye Batch Id')->toggleable(),
                TextColumn::make('process')->searchable()->sortable()->toggleable(),
                TextColumn::make('machine_name')->searchable()->sortable()->toggleable(),
                TextColumn::make('gsm_after')->sortable()->toggleable(),
                TextColumn::make('dia_after')->sortable()->toggleable(),
                TextColumn::make('shrinkage_l')->sortable()->toggleable(),
                TextColumn::make('shrinkage_w')->sortable()->toggleable(),
                TextColumn::make('done_at')->sortable()->toggleable()
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
        return ['process'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->process ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => FinishingLogResource\Pages\ListRecords::route('/'),
            'create' => FinishingLogResource\Pages\CreateRecord::route('/create'),
            'edit' => FinishingLogResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
