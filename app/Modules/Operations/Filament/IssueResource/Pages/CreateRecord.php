<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament\IssueResource\Pages;

use App\Modules\Operations\Filament\IssueResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = IssueResource::class;
}
