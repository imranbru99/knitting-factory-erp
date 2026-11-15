<?php

declare(strict_types=1);

namespace App\Modules\Masters\Filament;

use App\Modules\Masters\Models\Party;
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

class PartyResource extends Resource
{
    protected static ?string $model = Party::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Masters';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';

    public static function moduleKey(): string
    {
        return 'masters';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Party')->columns(2)->schema([
                    TextInput::make('code')->maxLength(255)->required(),
                    TextInput::make('name')->maxLength(255)->required(),
                    TextInput::make('name_bn')->maxLength(255),
                    Select::make('party_type')->options(['buyer' => 'Buyer', 'supplier' => 'Supplier', 'subcontractor' => 'Subcontractor', 'bank' => 'Bank', 'cf_agent' => 'Cf Agent', 'transporter' => 'Transporter'])->required(),
                    TextInput::make('phone')->maxLength(255),
                    TextInput::make('email')->maxLength(255),
                    Textarea::make('address')->rows(3)->columnSpanFull(),
                    TextInput::make('credit_limit')->numeric(),
                    TextInput::make('credit_days')->numeric(),
                    TextInput::make('rating')->numeric(),
                    Toggle::make('is_blacklisted'),
                    TextInput::make('currency_code')->maxLength(255),
                    TextInput::make('vat_bin')->maxLength(255),
                    DatePicker::make('documents_expire_on')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->searchable()->sortable()->toggleable(),
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('name_bn')->searchable()->sortable()->toggleable(),
                TextColumn::make('party_type')->searchable()->sortable()->toggleable(),
                TextColumn::make('phone')->searchable()->sortable()->toggleable(),
                TextColumn::make('email')->searchable()->sortable()->toggleable(),
                TextColumn::make('credit_limit')->sortable()->toggleable(),
                TextColumn::make('credit_days')->sortable()->toggleable()
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
        return ['code', 'name', 'phone'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->name ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => PartyResource\Pages\ListRecords::route('/'),
            'create' => PartyResource\Pages\CreateRecord::route('/create'),
            'edit' => PartyResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
