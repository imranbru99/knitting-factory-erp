<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Filament\WorkOrderResource\Pages;

use App\Modules\Maintenance\Filament\WorkOrderResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = WorkOrderResource::class;
}
