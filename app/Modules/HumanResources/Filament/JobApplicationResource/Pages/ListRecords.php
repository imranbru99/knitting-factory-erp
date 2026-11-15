<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\JobApplicationResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\HumanResources\Filament\JobApplicationResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = JobApplicationResource::class;
}
