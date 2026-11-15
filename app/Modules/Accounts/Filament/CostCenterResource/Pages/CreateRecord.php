<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Filament\CostCenterResource\Pages;

use App\Modules\Accounts\Filament\CostCenterResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = CostCenterResource::class;
}
