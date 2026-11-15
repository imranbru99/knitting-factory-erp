<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\AttachmentResource\Pages;

use App\Modules\Core\Filament\AttachmentResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = AttachmentResource::class;
}
