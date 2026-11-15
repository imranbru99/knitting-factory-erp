<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\GoodsReceiptResource\Pages;

use App\Modules\Procurement\Filament\GoodsReceiptResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = GoodsReceiptResource::class;
}
