<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Filament\DeliveryChallanResource\Pages;

use App\Modules\Delivery\Filament\DeliveryChallanResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = DeliveryChallanResource::class;
}
