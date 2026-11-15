<?php

declare(strict_types=1);

namespace App\Modules\Website\Filament\FormSubmissionResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Website\Filament\FormSubmissionResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = FormSubmissionResource::class;
}
