<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Filament\YarnIssueResource\Pages;

use App\Modules\Inventory\Filament\YarnIssueResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = YarnIssueResource::class;
}
