<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\ApprovalRequestResource\Pages;

use App\Modules\Core\Filament\ApprovalRequestResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = ApprovalRequestResource::class;
}
