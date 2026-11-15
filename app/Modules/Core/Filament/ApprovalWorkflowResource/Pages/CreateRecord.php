<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\ApprovalWorkflowResource\Pages;

use App\Modules\Core\Filament\ApprovalWorkflowResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = ApprovalWorkflowResource::class;
}
