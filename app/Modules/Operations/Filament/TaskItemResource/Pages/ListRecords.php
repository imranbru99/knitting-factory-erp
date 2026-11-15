<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament\TaskItemResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Operations\Filament\TaskItemResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = TaskItemResource::class;
}
