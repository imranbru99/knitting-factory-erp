<?php

declare(strict_types=1);

namespace App\Modules\Quality\Filament\BuyerClaimResource\Pages;

use App\Modules\Quality\Filament\BuyerClaimResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = BuyerClaimResource::class;
}
