<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\ApprovalWorkflowResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Core\Filament\ApprovalWorkflowResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = ApprovalWorkflowResource::class;
}
