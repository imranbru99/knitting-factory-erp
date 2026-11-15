<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Filament\SubcontractJobResource\Pages;

use App\Modules\Knitting\Filament\SubcontractJobResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = SubcontractJobResource::class;
}
