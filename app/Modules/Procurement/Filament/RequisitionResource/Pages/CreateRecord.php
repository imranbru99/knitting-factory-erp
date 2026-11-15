<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\RequisitionResource\Pages;

use App\Modules\Procurement\Filament\RequisitionResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = RequisitionResource::class;
}
