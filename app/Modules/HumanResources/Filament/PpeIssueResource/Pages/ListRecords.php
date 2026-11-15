<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\PpeIssueResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\HumanResources\Filament\PpeIssueResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = PpeIssueResource::class;
}
