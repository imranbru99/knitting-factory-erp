<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\RequisitionResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Procurement\Filament\RequisitionResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = RequisitionResource::class;
}
