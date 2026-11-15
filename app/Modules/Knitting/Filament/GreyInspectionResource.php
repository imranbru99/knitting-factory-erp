<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament;

use App\Modules\Knitting\Models\GreyInspection;
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

class GreyInspectionResource extends Resource
{
    protected static ?string $model = GreyInspection::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Knitting';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'grade';

    public static function moduleKey(): string
    {
        return 'knitting';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('GreyInspection')->columns(2)->schema([
                    Select::make('roll_id')->label('Roll Id')->relationship('roll', 'number')->required()->searchable()->preload(),
                    Select::make('inspector_id')->label('Inspector Id')->relationship('inspector', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('gsm')->numeric(),
                    TextInput::make('dia')->numeric(),
                    TextInput::make('points')->numeric(),
                    TextInput::make('grade')->maxLength(255),
                    TextInput::make('length_m')->numeric(),
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
                TextColumn::make('inspector.name')->label('Inspector Id')->toggleable(),
                TextColumn::make('gsm')->sortable()->toggleable(),
                TextColumn::make('dia')->sortable()->toggleable(),
                TextColumn::make('points')->sortable()->toggleable(),
                TextColumn::make('grade')->searchable()->sortable()->toggleable(),
                TextColumn::make('length_m')->sortable()->toggleable(),
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
            'index' => GreyInspectionResource\Pages\ListRecords::route('/'),
            'create' => GreyInspectionResource\Pages\CreateRecord::route('/create'),
            'edit' => GreyInspectionResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
