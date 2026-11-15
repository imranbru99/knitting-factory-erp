<?php

declare(strict_types=1);

namespace App\Modules\Waste\Filament\WasteSaleResource\Pages;

use App\Modules\Waste\Filament\WasteSaleResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = WasteSaleResource::class;
}
