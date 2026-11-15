<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament;

use App\Modules\HumanResources\Models\JobApplication;
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

class JobApplicationResource extends Resource
{
    protected static ?string $model = JobApplication::class;

    protected static string | \UnitEnum | null $navigationGroup = 'HR & Payroll';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';

    public static function moduleKey(): string
    {
        return 'humanresources';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('JobApplication')->columns(2)->schema([
                    Select::make('job_posting_id')->label('Job Posting Id')->relationship('job_posting', 'title')->required()->searchable()->preload(),
                    TextInput::make('name')->maxLength(255)->required(),
                    TextInput::make('email')->maxLength(255),
                    TextInput::make('phone')->maxLength(255),
                    Select::make('status')->options(['new' => 'New', 'shortlisted' => 'Shortlisted', 'rejected' => 'Rejected', 'hired' => 'Hired'])->nullable(),
                    Textarea::make('note')->rows(3)->columnSpanFull()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job_posting.title')->label('Job Posting Id')->toggleable(),
                TextColumn::make('name')->searchable()->sortable()->toggleable(),
                TextColumn::make('email')->searchable()->sortable()->toggleable(),
                TextColumn::make('phone')->searchable()->sortable()->toggleable(),
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
        return ['name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->name ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => JobApplicationResource\Pages\ListRecords::route('/'),
            'create' => JobApplicationResource\Pages\CreateRecord::route('/create'),
            'edit' => JobApplicationResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
