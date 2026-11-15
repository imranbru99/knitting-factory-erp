<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament;

use App\Modules\Delivery\Models\GatePass;
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

class GatePassResource extends Resource
{
    protected static ?string $model = GatePass::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Delivery';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'number';

    public static function moduleKey(): string
    {
        return 'delivery';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('GatePass')->columns(2)->schema([
                    TextInput::make('number')->maxLength(255),
                    Select::make('direction')->options(['in' => 'In', 'out' => 'Out'])->required(),
                    TextInput::make('ref_type')->maxLength(255),
                    TextInput::make('ref_id')->numeric(),
                    TextInput::make('vehicle_no')->maxLength(255),
                    Select::make('status')->options(['draft' => 'Draft', 'approved' => 'Approved', 'verified' => 'Verified'])->nullable(),
                    DateTimePicker::make('verified_at')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->searchable()->sortable()->toggleable(),
                TextColumn::make('direction')->searchable()->sortable()->toggleable(),
                TextColumn::make('ref_type')->searchable()->sortable()->toggleable(),
                TextColumn::make('ref_id')->sortable()->toggleable(),
                TextColumn::make('vehicle_no')->searchable()->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable(),
                TextColumn::make('verified_at')->sortable()->toggleable()
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
        return ['number'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->number ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => GatePassResource\Pages\ListRecords::route('/'),
            'create' => GatePassResource\Pages\CreateRecord::route('/create'),
            'edit' => GatePassResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
