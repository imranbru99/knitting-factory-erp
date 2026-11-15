<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Filament\JobApplicationResource\Pages;

use App\Modules\HumanResources\Filament\JobApplicationResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = JobApplicationResource::class;
}
