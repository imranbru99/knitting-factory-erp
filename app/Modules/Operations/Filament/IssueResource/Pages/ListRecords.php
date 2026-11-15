<?php

declare(strict_types=1);

namespace App\Modules\Operations\Filament\IssueResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Operations\Filament\IssueResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = IssueResource::class;
}
