<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament;

use App\Modules\Core\Models\ApprovalRequest;
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

class ApprovalRequestResource extends Resource
{
    protected static ?string $model = ApprovalRequest::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Company';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'id';

    public static function moduleKey(): string
    {
        return 'core';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('ApprovalRequest')->columns(2)->schema([
                    Select::make('approval_workflow_id')->label('Approval Workflow Id')->relationship('approval_workflow', 'name')->nullable()->searchable()->preload(),
                    TextInput::make('approvable_type')->maxLength(255)->required(),
                    TextInput::make('approvable_id')->numeric()->required(),
                    Select::make('status')->options(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'escalated' => 'Escalated'])->required(),
                    TextInput::make('current_level')->numeric(),
                    TextInput::make('submitted_by')->numeric()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('approval_workflow.name')->label('Approval Workflow Id')->toggleable(),
                TextColumn::make('approvable_type')->searchable()->sortable()->toggleable(),
                TextColumn::make('approvable_id')->sortable()->toggleable(),
                TextColumn::make('status')->searchable()->sortable()->toggleable(),
                TextColumn::make('current_level')->sortable()->toggleable(),
                TextColumn::make('submitted_by')->sortable()->toggleable()
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
        return [];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->id ?? $record->getKey());
    }

    public static function getPages(): array
    {
        return [
            'index' => ApprovalRequestResource\Pages\ListRecords::route('/'),
            'create' => ApprovalRequestResource\Pages\CreateRecord::route('/create'),
            'edit' => ApprovalRequestResource\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}
