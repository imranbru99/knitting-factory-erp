<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\ApprovalRequestResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\ApprovalRequestResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = ApprovalRequestResource::class;
}
