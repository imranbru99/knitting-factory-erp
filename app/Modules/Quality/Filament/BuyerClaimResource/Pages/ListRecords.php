<?php

declare(strict_types=1);

namespace App\Modules\Quality\Filament\BuyerClaimResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Quality\Filament\BuyerClaimResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = BuyerClaimResource::class;
}
