<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament\TaskItemResource\Pages;

use App\Modules\Operations\Filament\TaskItemResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = TaskItemResource::class;
}
