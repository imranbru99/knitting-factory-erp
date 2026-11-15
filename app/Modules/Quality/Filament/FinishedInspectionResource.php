<?php

declare(strict_types=1);

namespace App\Modules\Quality\Filament;

use App\Modules\Quality\Models\FinishedInspection;
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

class FinishedInspectionResource extends Resource
{
    protected static ?string $model = FinishedInspection::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Quality';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'grade';

    public static function moduleKey(): string
    {
        return 'quality';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('FinishedInspection')->columns(2)->schema([
                    Select::make('roll_id')->label('Roll Id')->relationship('roll', 'number')->required()->searchable()->preload(),
                    TextInput::make('points_per_100')->numeric(),
                    TextInput::make('grade')->maxLength(255),
                    TextInput::make('length_yd')->numeric(),
                    TextInput::make('width_in')->numeric(),
                    Select::make('status')->options(['draft' => 'Draft', 'released' => 'Released', 'hold' => 'Hold'])->nullable(),
                    Repeater::make('lines')->relationship()->schema([
                        Select::make('defect_id')->label('Defect Id')->relationship('defect', 'name')->nullable()->searchable()->preload(),
                        TextInput::make('position_m')->numeric(),
                        TextInput::make('points')->numeric()
                    ])->columnSpanFull()->collapsible()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('roll.number')->label('Roll Id')->toggleable(),
                TextColumn::make('points_per_100')->sortable()->toggleable(),
                TextColumn::make('grade')->searchable()->sortable()->toggleable(),
                TextColumn::make('length_yd')->sortable()->toggleable(),
                TextColumn::make('width_in')->sortable()->toggleable(),
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
        return ['grade'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->grade ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => FinishedInspectionResource\Pages\ListRecords::route('/'),
            'create' => FinishedInspectionResource\Pages\CreateRecord::route('/create'),
            'edit' => FinishedInspectionResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
