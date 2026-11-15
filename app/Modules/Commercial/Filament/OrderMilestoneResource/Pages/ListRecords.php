<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament\OrderMilestoneResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Commercial\Filament\OrderMilestoneResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = OrderMilestoneResource::class;
}
