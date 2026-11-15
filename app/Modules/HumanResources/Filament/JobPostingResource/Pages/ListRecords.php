<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\JobPostingResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\HumanResources\Filament\JobPostingResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = JobPostingResource::class;
}
