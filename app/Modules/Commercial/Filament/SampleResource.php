<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament;

use App\Modules\Commercial\Models\Sample;
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

class SampleResource extends Resource
{
    protected static ?string $model = Sample::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Merchandising';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'kind';

    public static function moduleKey(): string
    {
        return 'commercial';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Sample')->columns(2)->schema([
                    Select::make('inquiry_id')->label('Inquiry Id')->relationship('inquiry', 'number')->nullable()->searchable()->preload(),
                    Select::make('kind')->options(['swatch' => 'Swatch', 'lab_dip' => 'Lab Dip', 'hanger' => 'Hanger'])->required(),
                    Select::make('status')->options(['pending' => 'Pending', 'submitted' => 'Submitted', 'approved' => 'Approved', 'rejected' => 'Rejected'])->nullable(),
                    Textarea::make('comments')->rows(3)->columnSpanFull(),
                    DatePicker::make('approved_on')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('inquiry.number')->label('Inquiry Id')->toggleable(),
                TextColumn::make('kind')->searchable()->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable(),
                TextColumn::make('approved_on')->sortable()->toggleable()
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
            'index' => SampleResource\Pages\ListRecords::route('/'),
            'create' => SampleResource\Pages\CreateRecord::route('/create'),
            'edit' => SampleResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
