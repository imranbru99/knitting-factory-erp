<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\PpeIssueResource\Pages;

use App\Modules\HumanResources\Filament\PpeIssueResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = PpeIssueResource::class;
}
