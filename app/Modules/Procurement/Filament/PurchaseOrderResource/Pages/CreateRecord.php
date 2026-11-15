<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\PurchaseOrderResource\Pages;

use App\Modules\Procurement\Filament\PurchaseOrderResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = PurchaseOrderResource::class;
}
