<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament\OrderMilestoneResource\Pages;

use App\Modules\Commercial\Filament\OrderMilestoneResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = OrderMilestoneResource::class;
}
